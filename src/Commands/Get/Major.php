<?php

namespace PHLAK\SemVerCLI\Commands\Get;

use PHLAK\SemVerCLI\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Major extends Command
{
    protected function configure(): void
    {
        $this->setName('get:major');
        $this->setDescription('Get the major version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();

        $output->writeln((string) $version->major);

        return Command::SUCCESS;
    }
}
