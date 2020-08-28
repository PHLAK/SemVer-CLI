<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minor extends Command
{
    protected function configure(): void
    {
        $this->setName('get:minor');
        $this->setDescription('Get the minor version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();

        $output->writeln((string) $version->minor);

        return Command::SUCCESS;
    }
}
