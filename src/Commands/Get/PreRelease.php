<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreRelease extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('get:pre-release');
        $this->setDescription('Get the pre-release version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $semver = $this->readVersionFromDisk();

        $output->writeln($semver->preRelease);

        return Command::SUCCESS;
    }
}
