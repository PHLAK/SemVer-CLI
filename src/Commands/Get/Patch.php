<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Patch extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('get:patch');
        $this->setDescription('Get the patch version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $semver = $this->readVersionFromDisk();

        $output->writeln($semver->patch);

        return Command::SUCCESS;
    }
}