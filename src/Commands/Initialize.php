<?php

namespace SemVerCli\Commands;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use SemVerCli\Exceptions\InitializationException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Initialize extends Command
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
        try {
            $version = $input->getOption('parse')
                ? Version::parse($input->getArgument('version'))
                : new Version($input->getArgument('version') ?? '0.1.0');
        } catch (InvalidVersionException $exception) {
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

            return Command::FAILURE;
        }

        try {
            $this->adapter->initializeVersion($version);
        } catch (InitializationException $exception) {
            $output->writeln(sprintf('<comment>%s</comment>', $exception->getMessage()));

            return self::INITIALIZATION_FAILURE;
        }

        $output->writeln(
            sprintf('Semantic versioning initialized to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
