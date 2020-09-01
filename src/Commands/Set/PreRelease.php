<?php

namespace PHLAK\SemVerCLI\Commands\Set;

use PHLAK\SemVerCLI\Commands\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreRelease extends Command
{
    public function configure(): void
    {
        $this->setName('set:pre-release');
        $this->setDescription('Set the pre-release string to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New pre-release value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();
        $this->adapter->writeVersion($version->setPreRelease($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
