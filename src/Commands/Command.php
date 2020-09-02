<?php

namespace PHLAK\SemVerCLI\Commands;

use PHLAK\SemVerCLI\Adapters\AdapterFactory;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    public const CONFIG_FILE = 'semver.config.php';

    /** @var array */
    protected $config = [];

    /** @var AdapterInterface */
    protected $adapter;

    /** {@inheritdoc} */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        if (is_readable(self::CONFIG_FILE)) {
            $this->config = require self::CONFIG_FILE;
        }

        $this->configureFileOption($input);
        $this->configureComposerOption($input);
        $this->configureAdapterOption($input);

        $this->adapter = AdapterFactory::make($input);
    }

    /** Configure the 'file' option before command execution. */
    private function configureFileOption(InputInterface $input): void
    {
        if ($input->getOption('file') !== false) {
            return;
        }

        if ($fileName = getenv('SEMVER_CLI_FILE_NAME')) {
            $input->setOption('file', $fileName);

            return;
        }

        $input->setOption('file', $this->config['file_name'] ?? 'VERSION');
    }

    /** Configre the 'composer' option before command execution. */
    private function configureComposerOption(InputInterface $input): void
    {
        if ($input->getOption('composer') !== false) {
            return;
        }

        if ($composerFile = getenv('SEMVER_CLI_COMPOSER_FILE')) {
            $input->setOption('composer', $composerFile);

            return;
        }

        $input->setOption('composer', $this->config['composer_file'] ?? 'composer.json');
    }

    /** Configure the 'adapter' option before command execution. */
    private function configureAdapterOption(InputInterface $input): void
    {
        if ($input->getOption('adapter') !== false) {
            return;
        }

        if ($adapter = getenv('SEMVER_CLI_ADAPTER')) {
            $input->setOption('adapter', $adapter);

            return;
        }

        $input->setOption('adapter', $this->config['adapter'] ?? 'file');
    }
}