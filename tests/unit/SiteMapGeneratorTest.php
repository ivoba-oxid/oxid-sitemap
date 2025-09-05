<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Tests\Unit;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;
use IvobaOxid\OxidSiteMap\Filter\FilterInterface;
use IvobaOxid\OxidSiteMap\Query\QueryInterface;
use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SiteMapGeneratorTest extends TestCase
{
    private const TEST_FILEPATH = 'var/test';
    private const TEST_FILENAME = 'sitemap.xml';
    private const TEST_SITE_URL = 'https://example.com';

    private SiteMapGenerator $generator;
    private Config $config;
    private string $tempDir;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a virtual filesystem for testing
        $this->tempDir = vfsStream::setup('root', null, [
            'var' => []
        ])->url();
        
        $this->config = new Config(
            $this->tempDir . '/' . self::TEST_FILEPATH,
            self::TEST_FILENAME,
            self::TEST_SITE_URL
        );
    }

    public function testGenerateCreatesValidXml(): void
    {
        // Create a mock query that returns test pages
        $query = $this->createMockQuery([
            new Page('https://example.com/page1', '1.0', '2023-01-01', 'daily'),
            new Page('https://example.com/page2', '0.8', '2023-01-02', 'weekly'),
        ]);

        $this->generator = new SiteMapGenerator($this->config, [$query]);
        $this->generator->generate();

        $filePath = $this->tempDir . '/' . self::TEST_FILEPATH . '/' . self::TEST_FILENAME;
        $this->assertFileExists($filePath);

        $xmlContent = file_get_contents($filePath);
        $this->assertIsString($xmlContent);
        $this->assertStringContainsString('<urlset', $xmlContent);
        $this->assertStringContainsString('https://example.com/page1', $xmlContent);
        $this->assertStringContainsString('1.0', $xmlContent);
        $this->assertStringContainsString('2023-01-01', $xmlContent);
        $this->assertStringContainsString('daily', $xmlContent);
        
        // Clean up
        unlink($filePath);
    }

    public function testGenerateWithFilters(): void
    {
        // Create test pages
        $pages = [
            new Page('https://example.com/included', '1.0', '2023-01-01', 'daily'),
            new Page('https://example.com/excluded', '0.8', '2023-01-02', 'weekly'),
        ];

        // Create a mock query
        $query = $this->createMockQuery($pages);
        
        // Create a mock filter that excludes the second page
        $filter = $this->createMock(FilterInterface::class);
        $filter->method('filter')
               ->willReturnCallback(fn($page) => $page->getUrl() === 'https://example.com/excluded');

        $this->generator = new SiteMapGenerator($this->config, [$query], false, [$filter]);
        $this->generator->generate();

        $filePath = $this->tempDir . '/' . self::TEST_FILEPATH . '/' . self::TEST_FILENAME;
        $xmlContent = file_get_contents($filePath);
        $this->assertIsString($xmlContent);
        $this->assertStringContainsString('https://example.com/included', $xmlContent);
        $this->assertStringNotContainsString('https://example.com/excluded', $xmlContent);
        
        // Clean up
        unlink($filePath);
    }

    public function testGenerateWithLowercaseUrls(): void
    {
        $testUrl = 'https://example.com/Test-Page';
        $query = $this->createMockQuery([
            new Page($testUrl, '1.0', '2023-01-01', 'daily'),
        ]);

        $this->generator = new SiteMapGenerator($this->config, [$query], true);
        $this->generator->generate();

        $filePath = $this->tempDir . '/' . self::TEST_FILEPATH . '/' . self::TEST_FILENAME;
        $xmlContent = file_get_contents($filePath);
        $this->assertIsString($xmlContent);
        $this->assertStringContainsString(strtolower($testUrl), $xmlContent);
        
        // Clean up
        unlink($filePath);
    }

    public function testGenerateThrowsExceptionWhenDirectoryNotWritable(): void
    {
        $this->expectException(\RuntimeException::class);
        
        // Create a non-writable directory
        $nonWritableDir = $this->tempDir . '/non-writable';
        mkdir($nonWritableDir, 0444, true);
        
        $config = new Config(
            $nonWritableDir,
            self::TEST_FILENAME,
            self::TEST_SITE_URL
        );
        
        $query = $this->createMockQuery([new Page('https://example.com/test', '1.0', '2023-01-01', 'daily')]);
        $generator = new SiteMapGenerator($config, [$query]);
        
        $generator->generate();
    }

    /**
     * Helper method to create a mock QueryInterface
     *
     * @param array<Page> $pages Pages to return from getPages()
     * @return QueryInterface
     */
    private function createMockQuery(array $pages = []): QueryInterface
    {
        $query = $this->createMock(QueryInterface::class);
        $query->method('getPages')->willReturn($pages);
        
        return $query;
    }
}
