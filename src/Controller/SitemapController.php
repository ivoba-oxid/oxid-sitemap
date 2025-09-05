<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Exception\StandardException;
use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use OxidEsales\EshopCommunity\Core\Controller\BaseController;
use \OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;

/**
 * Handles the sitemap generation and output
 */
class SitemapController extends BaseController
{
    private SiteMapGenerator $siteMapGenerator;

    public function __construct()
    {
        parent::__construct();

        // Get the site map generator from the DI container
        $container = ContainerFactory::getInstance()->getContainer();
        $this->siteMapGenerator = $container->get(SiteMapGenerator::class);
    }

    /**
     * Generate and output the sitemap XML
     */
    public function render(): Response
    {
        try {
            // Generate the sitemap
            $this->siteMapGenerator->generate();

            // Get the path to the generated sitemap file
            $sitemapPath = $this->siteMapGenerator->getConfig()->getFilepath() .
                          '/' . $this->siteMapGenerator->getConfig()->getFilename();

            // Check if the file exists and is readable
            if (!file_exists($sitemapPath) || !is_readable($sitemapPath)) {
                throw new StandardException('Sitemap file not found or not readable');
            }

            // Output the XML with appropriate headers
            $response = new Response(
                file_get_contents($sitemapPath),
                Response::HTTP_OK,
                ['Content-Type' => 'application/xml; charset=UTF-8']
            );

            // Set caching headers (1 hour)
            $response->setMaxAge(3600);
            $response->setSharedMaxAge(3600);
            $response->setPublic();

            return $response;
        } catch (\Exception $e) {
            // Log the error
            Registry::getLogger()->error('Sitemap generation failed: ' . $e->getMessage(), [$e]);

            // Return 500 error
            return new Response(
                'Sitemap generation failed: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
