<?php

namespace SemVerCli\Commands;

use PHLAK\SemVer\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Initialize extends BaseCommand
{
    protected const PREVIOUSLY_INITIALIZED = 200;

    protected function configure(): void
    {
        $this->setName('initialize')->setAliases(['init']);
        $this->setDescription('Initialize semantic versioning in the current path');
        $this->addArgument('version', InputArgument::OPTIONAL, 'The version used for initialization');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (file_exists(self::VERSION_FILE)) {
            $output->writeln(
                '<comment>Semantic versioning already initialized in this directory</comment>'
            );

            return self::PREVIOUSLY_INITIALIZED;
        }

        $version = new Version($input->getArgument('version') ?? '0.1.0');

        file_put_contents(self::VERSION_FILE, serialize($version), LOCK_EX);

        $output->writeln(
            sprintf('Semantic versioning initialized, version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
