<?php

namespace PHLAK\SemVerCLI\Commands\Get;

use PHLAK\SemVerCLI\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends Command
{
    protected function configure(): void
    {
        $this->setName('get:build');
        $this->setDescription('Get the build version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();

        if ($output->isVerbose()) {
            $output->writeln(
                sprintf('The build value is <info>%s</info>', var_export($version->build, true))
            );
        }

        if ($version->build !== null) {
            $output->writeln((string) $version->build);
        }

        return Command::SUCCESS;
    }
}
