<?php

namespace SemVerCli\Commands;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Initialize extends BaseCommand
{
    protected function configure(): void
    {
        $this->setName('initialize')->setAliases(['init']);
        $this->setDescription('Initialize semantic versioning in the current path');
        $this->addOption('parse', 'p', InputOption::VALUE_NONE, 'Attempt to parse an incomplete version string');
        $this->addArgument('version', InputArgument::OPTIONAL, 'The version used for initialization');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (file_exists($input->getOption('file'))) {
            $output->writeln(
                '<comment>Semantic versioning already initialized in this directory</comment>'
            );

            return self::PREVIOUSLY_INITIALIZED;
        }

        try {
            $version = $input->getOption('parse')
                ? Version::parse($input->getArgument('version'))
                : new Version($input->getArgument('version') ?? '0.1.0');
        } catch (InvalidVersionException $exception) {
            $output->writeln('<error>Failed to initialize, invalid semantic version string provided</error>');

            return Command::FAILURE;
        }

        $this->writeVersionToDisk($input, $version);

        $output->writeln(
            sprintf('Semantic versioning initialized, version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
