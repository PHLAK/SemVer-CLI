<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('get:build');
        $this->setDescription('Get the build version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk($input);

        if ($version->build === null) {
            if ($output->isVerbose()) {
                $output->writeln('<comment>The build value is not set</comment>');
            }

            return self::VALUE_NOT_SET;
        }

        $output->writeln($version->build);

        return Command::SUCCESS;
    }
}
