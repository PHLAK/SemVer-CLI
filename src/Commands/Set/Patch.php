<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Patch extends BaseCommand
{
    public function configure(): void
    {
        $this->setName('set:patch');
        $this->setDescription('Set the patch version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New patch version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $semver = $this->readVersionFromDisk();
        $this->writeVersionToDisk($semver->setPatch($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', $semver->prefix(''))
        );

        return Command::SUCCESS;
    }
}
