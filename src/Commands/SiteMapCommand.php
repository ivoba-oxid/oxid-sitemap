<?php

namespace IvobaOxid\OxidSiteMap\Commands;

use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Console\AbstractShopAwareCommand;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\TransactionServiceInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteMapCommand extends AbstractShopAwareCommand
{
    private $queryBuilderFactory;
    private $transactionService;
    private $siteMapGenerator;

    /**
     * SiteMapCommand constructor.
     * @param QueryBuilderFactoryInterface $queryBuilderFactory
     * @param TransactionServiceInterface $transactionService
     * @param SiteMapGenerator $siteMapGenerator
     */
    public function __construct(
        QueryBuilderFactoryInterface $queryBuilderFactory,
        TransactionServiceInterface $transactionService,
        SiteMapGenerator $siteMapGenerator
    ) {
        $this->queryBuilderFactory = $queryBuilderFactory;
        $this->transactionService  = $transactionService;
        $this->siteMapGenerator    = $siteMapGenerator;
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
            'Generated Sitemap in '.$this->siteMapGenerator->getConfig()->getFilename().'/'.$this->siteMapGenerator->getConfig()->getFilename()
        );
    }
}
