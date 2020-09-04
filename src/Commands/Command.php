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
    public const DEFAULT_STORAGE_ADAPTER = 'file';
    public const DEFUALT_COMPOSER_FILE = 'composer.json';
    public const DEFAULT_VERSION_FILE = 'VERSION';

    /** @var array */
    protected $config = [];

    /** @var AdapterInterface */
    protected $adapter;

    /** {@inheritdoc} */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        if (is_readable(self::CONFIG_FILE)) {
            $this->config = (array) require self::CONFIG_FILE;
        }

        $input->setOption('file', $this->getFileOption($input));
        $input->setOption('composer', $this->getComposerOption($input));
        $input->setOption('adapter', $this->getAdapterOption($input));

        $this->adapter = AdapterFactory::make($input);
    }

    /** Get the 'file' option. */
    private function getFileOption(InputInterface $input): string
    {
        if ($input->getOption('file') !== false) {
            return (string) $input->getOption('file');
        }

        if ($fileName = getenv('SEMVER_CLI_FILE_NAME')) {
            return $fileName;
        }

        if (isset($this->config['file_name'])) {
            return (string) $this->config['file_name'];
        }

        return self::DEFAULT_VERSION_FILE;
    }

    /** Get the 'composer' option. */
    private function getComposerOption(InputInterface $input): string
    {
        if ($input->getOption('composer') !== false) {
            return (string) $input->getOption('composer');
        }

        if ($composerFile = getenv('SEMVER_CLI_COMPOSER_FILE')) {
            return $composerFile;
        }

        if (isset($this->config['composer_file'])) {
            return (string) $this->config['composer_file'];
        }

        return self::DEFUALT_COMPOSER_FILE;
    }

    /** Get the 'adapter' option. */
    private function getAdapterOption(InputInterface $input): string
    {
        if ($input->getOption('adapter') !== false) {
            return (string) $input->getOption('adapter');
        }

        if ($adapter = getenv('SEMVER_CLI_ADAPTER')) {
            return $adapter;
        }

        if (isset($this->config['adapter'])) {
            return (string) $this->config['adapter'];
        }

        return self::DEFAULT_STORAGE_ADAPTER;
    }
}
