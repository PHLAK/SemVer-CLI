<?php

namespace SemVerCli\Adapters;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use SemVerCli\Contracts\AdapterInterface;
use SemVerCli\Exceptions\DestroyException;
use SemVerCli\Exceptions\InitializationException;
use SemVerCli\Exceptions\ReadException;
use SemVerCli\Exceptions\WriteException;
use Symfony\Component\Console\Input\InputInterface;

class FileAdapter implements AdapterInterface
{
    /** @var InputInterface */
    protected $input;

    /** Create a new file adapter. */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /** {@inheritdoc} */
    public function initializeVersion(Version $version): void
    {
        if (file_exists($this->input->getOption('file'))) {
            throw new InitializationException('Semantic versioning already initialized');
        }

        touch($this->input->getOption('file'));

        $this->writeVersion($version);
    }

    /** {@inheritdoc} */
    public function readVersion(): Version
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw new ReadException('Semantic versioning is not intialized');
        }

        if (! is_readable($this->input->getOption('file'))) {
            throw new ReadException('Version file exists but is not readbale');
        }

        if (! $contents = @file_get_contents($this->input->getOption('file'))) {
            throw new ReadException('Failed reading version from version file');
        }

        try {
            return new Version($contents);
        } catch (InvalidVersionException $exception) {
            throw new ReadException('Failed to parse version from version file');
        }
    }

    /** {@inheritdoc} */
    public function writeVersion(Version $version): void
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw new WriteException('Semantic versioning is not intialized');
        }

        if (! is_writable($this->input->getOption('file'))) {
            throw new WriteException('Version file exists but is not writable');
        }

        if (! file_put_contents($this->input->getOption('file'), (string) $version, LOCK_EX)) {
            throw new WriteException('Failed writing to version file');
        }
    }

    /** {@inheritdoc} */
    public function destroyVersion(): void
    {
        throw new DestroyException('Failed to destroy version');
    }
}
