<?php

declare(strict_types=1);

namespace IvobaOxid\OxidSiteMap\Commands;

use IvobaOxid\OxidSiteMap\SiteMapGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Console command to generate the sitemap XML file
 */
#[AsCommand(
    name: 'ivoba-oxid:sitemap:generate',
    description: 'Generates the sitemap XML file for search engines',
    aliases: []
)]
class SiteMapCommand extends Command
{
    private ?SymfonyStyle $io = null;

    public function __construct(
        private readonly SiteMapGenerator $siteMapGenerator
    ) {
        parent::__construct();
    }

    /**
     * Configure the command
     */
    protected function configure(): void
    {
        $this->setHelp('This command generates a sitemap XML file that helps search engines index your shop.');
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
