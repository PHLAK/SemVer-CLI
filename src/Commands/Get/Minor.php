<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minor extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('get:minor');
        $this->setDescription('Get the minor version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk($input);

        $output->writeln($version->minor);

        return Command::SUCCESS;
    }
}
