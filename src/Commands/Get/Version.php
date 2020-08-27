<?php

namespace SemVerCli\Commands\Get;

use SemVerCli\Commands\Command;
use SemVerCli\Traits\ReadsVersion;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Version extends Command
{
    use ReadsVersion;

    protected function configure(): void
    {
        $this->setName('get:version');
        $this->setDescription('Get the full version');
        $this->addOption('prefix', null, InputOption::VALUE_NONE, "Prefix the version string with 'v'");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);

        $output->writeln(
            $input->getOption('prefix') ? $version->prefix() : (string) $version
        );

        return Command::SUCCESS;
    }
}
