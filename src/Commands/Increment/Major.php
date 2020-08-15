<?php

namespace SemVerCli\Commands\Increment;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Major extends BaseCommand
{
    public function configure(): void
    {
        $this->setName('increment:major');
        $this->setDescription('Increment the major version by one');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk();
        $this->writeVersionToDisk($version->incrementMajor());

        $output->writeln(
            sprintf('Semantic version incremented to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
