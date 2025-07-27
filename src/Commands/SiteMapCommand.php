<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Commands;

use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Console\AbstractShopAwareCommand;
use OxidEsales\EshopCommunity\Internal\Framework\Console\CommandsProvider\CommandsProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Console command to generate the sitemap XML file
 */
class SiteMapCommand extends AbstractShopAwareCommand implements CommandsProviderInterface
{
    private const COMMAND_NAME = 'ivoba-oxid:sitemap:generate';

    private SiteMapGenerator $siteMapGenerator;
    private ?SymfonyStyle $io = null;

    public function __construct(SiteMapGenerator $siteMapGenerator)
    {
        parent::__construct(null);
        $this->siteMapGenerator = $siteMapGenerator;
    }

    /**
     * @inheritDoc
     */
    public static function getCommands(): array
    {
        return [self::getDefaultCommandName()];
    }

    /**
     * @inheritDoc
     */
    public static function getDefaultCommandName(): ?string
    {
        return self::COMMAND_NAME;
    }

    /**
     * Configure the command
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
             ->setDescription('Generates the sitemap XML file for search engines')
             ->setHelp('This command generates a sitemap XML file that helps search engines index your shop.');
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        
        try {
            $this->io->title('Generating Sitemap');
            
            // Generate the sitemap
            $this->siteMapGenerator->generate();
            
            // Get the path to the generated file
            $filePath = $this->siteMapGenerator->getConfig()->getFilepath() . 
                       '/' . $this->siteMapGenerator->getConfig()->getFilename();
            
            // Output success message
            $this->io->success(sprintf(
                'Sitemap successfully generated at: %s',
                $filePath
            ));
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->io->error(sprintf(
                'Error generating sitemap: %s',
                $e->getMessage()
            ));
            
            if ($this->io->isVerbose()) {
                $this->io->writeln($e->getTraceAsString());
            }
            
            return Command::FAILURE;
        }
    }
}
