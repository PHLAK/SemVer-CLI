<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends BaseCommand
{
    public function configure(): void
    {
        $this->setName('set:build');
        $this->setDescription('Set the build string to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New build value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $semver = $this->readVersionFromDisk();
        $this->writeVersionToDisk($semver->setBuild($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', $semver->prefix(''))
        );

        return Command::SUCCESS;
    }
}
