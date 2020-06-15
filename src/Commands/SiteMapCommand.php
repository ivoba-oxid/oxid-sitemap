<?php

namespace IvobaOxid\OxidSiteMap\Commands;

use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Console\AbstractShopAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteMapCommand extends AbstractShopAwareCommand
{
    private $siteMapGenerator;

    /**
     * SiteMapCommand constructor.
     * @param SiteMapGenerator $siteMapGenerator
     * @param null $name
     */
    public function __construct(
        SiteMapGenerator $siteMapGenerator,
        $name = null
    ) {
        $this->siteMapGenerator = $siteMapGenerator;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('ivoba-oxid:sitemap:generate')
            ->setDescription('Sitemap Generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating Sitemap');
        $this->siteMapGenerator->generate();
        $output->writeln(
            'Generated Sitemap in ' .
            $this->siteMapGenerator->getConfig()->getFilepath() .
            $this->siteMapGenerator->getConfig()->getFilename()
        );
    }
}
