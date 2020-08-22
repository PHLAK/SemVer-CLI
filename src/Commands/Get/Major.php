<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Traits\ReadsVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Major extends Command
{
    use ReadsVersion;

    protected function configure(): void
    {
        $this->setName('get:major');
        $this->setDescription('Get the major version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);

        $output->writeln((string) $version->major);

        return Command::SUCCESS;
    }
}
