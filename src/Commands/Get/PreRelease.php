<?php

namespace PHLAK\SemVerCLI\Commands\Get;

use PHLAK\SemVerCLI\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreRelease extends Command
{
    protected function configure(): void
    {
        $this->setName('get:pre-release');
        $this->setDescription('Get the pre-release version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();

        if ($output->isVerbose()) {
            $output->writeln(
                sprintf('The pre-release value is <info>%s</info>', var_export($version->preRelease, true))
            );
        }

        if ($version->preRelease !== null) {
            $output->writeln((string) $version->preRelease);
        }

        return Command::SUCCESS;
    }
}
