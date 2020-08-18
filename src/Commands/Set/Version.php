<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Version extends BaseCommand
{
    public function configure(): void
    {
        $this->setName('set:version');
        $this->setDescription('Set the version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk($input);
        $this->writeVersionToDisk($input, $version->setVersion($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
