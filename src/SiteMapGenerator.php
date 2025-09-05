<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap;

use IvobaOxid\OxidSiteMap\Entity\Config;
use IvobaOxid\OxidSiteMap\Entity\Page;
use IvobaOxid\OxidSiteMap\Filter\FilterInterface;
use IvobaOxid\OxidSiteMap\Query\QueryInterface;

/**
 * Class SiteMapGenerator
 *
 * Generates sitemap XML files based on provided queries and filters.
 */
class SiteMapGenerator
{
    private Config $config;
    /** @var array<QueryInterface> */
    private array $queries = [];
    private bool $lowerUrls;
    /** @var array<FilterInterface> */
    private array $filters = [];

    /**
     * @param Config $config The configuration for the sitemap
     * @param array<QueryInterface> $queries Array of query objects to fetch sitemap URLs
     * @param bool $lowerUrls Whether to convert URLs to lowercase
     * @param array<FilterInterface> $filters Array of filters to apply to URLs
     */
    public function __construct(Config $config, array $queries, bool $lowerUrls = false, array $filters = [])
    {
        $this->config = $config;
        $this->lowerUrls = $lowerUrls;

        foreach ($queries as $query) {
            $this->addQuery($query);
        }

        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public function addQuery(QueryInterface $query): void
    {
        $this->queries[] = $query;
    }

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * Generate the sitemap XML content
     *
     * @param array<Page> $pages Array of Page objects to include in the sitemap
     * @return string The generated XML content
     */
    protected function generateXml(array $pages): string
    {
        $xmlLines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' .
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
            'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">'
        ];

        foreach ($pages as $page) {
            if ($this->shouldFilterPage($page)) {
                continue;
            }

            $url = $this->lowerUrls ? strtolower($page->getUrl()) : $page->getUrl();

            $xmlLines[] = sprintf(
                '<url>' .
                '<loc>%s</loc>' .
                '<priority>%s</priority>' .
                '<lastmod>%s</lastmod>' .
                '<changefreq>%s</changefreq>' .
                '</url>',
                htmlspecialchars($url, ENT_QUOTES | ENT_XML1, 'UTF-8'),
                $page->getPriority(),
                $page->getLastmod(),
                $page->getChangefreq()
            );
        }

        $xmlLines[] = '</urlset>';

        return implode("\n", $xmlLines);
    }

    /**
     * Check if a page should be filtered out
     */
    private function shouldFilterPage(Page $page): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->filter($page)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create the sitemap XML file
     *
     * @throws \RuntimeException If the file cannot be written
     */
    protected function createXmlFile(string $xml): void
    {
        $file = $this->config->getFilepath() . '/' . $this->config->getFilename();

        $result = @file_put_contents($file, $xml);

        if ($result === false) {
            throw new \RuntimeException(sprintf('Could not write sitemap to %s', $file));
        }
    }

    /**
     * Generate the sitemap
     *
     * @throws \RuntimeException If the sitemap cannot be generated
     */
    public function generate(): void
    {
        $pages = [];

        foreach ($this->queries as $query) {
            $pages = array_merge($pages, $query->getPages());
        }

        $this->createXmlFile($this->generateXml($pages));
    }

    public function getConfig(): Config
    {
        return $this->config;
    }
}
