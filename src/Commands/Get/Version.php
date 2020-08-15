<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Version extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('get:version');
        $this->setDescription('Get the full version');
        $this->addOption('prefix', null, InputOption::VALUE_NONE, "Prefix the version string with 'v'");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $semver = $this->readVersionFromDisk();

        $output->writeln(
            $semver->prefix($input->getOption('prefix') ? 'v' : '')
        );

        return Command::SUCCESS;
    }
}
