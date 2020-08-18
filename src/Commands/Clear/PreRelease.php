<?php

namespace SemVerCli\Commands\Clear;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreRelease extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('clear:pre-release');
        $this->setDescription('Clear the pre-release value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk($input);
        $this->writeVersionToDisk($input, $version->setPreRelease(null));

        $output->writeln(
            sprintf('Pre-release value has been cleared, version is now <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}