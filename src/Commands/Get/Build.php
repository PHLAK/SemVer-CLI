<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Traits\ReadsVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends Command
{
    use ReadsVersion;

    protected function configure(): void
    {
        $this->setName('get:build');
        $this->setDescription('Get the build version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);

        if ($output->isVerbose()) {
            $output->writeln(
                sprintf('The build value is <info>%s</info>', var_export($version->build, true))
            );
        }

        if ($version->build !== null) {
            $output->writeln($version->build);
        }

        return Command::SUCCESS;
    }
}
