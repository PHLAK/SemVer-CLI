<?php

namespace PHLAK\SemVerCLI\Adapters;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use PHLAK\SemVerCLI\Exceptions\DestroyException;
use PHLAK\SemVerCLI\Exceptions\InitializationException;
use PHLAK\SemVerCLI\Exceptions\ReadException;
use PHLAK\SemVerCLI\Exceptions\WriteException;
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
            throw new WriteException(self::NOT_INITIALIZED);
        }

        if (! is_writable($this->input->getOption('file'))) {
            throw new WriteException(self::NOT_WRITABLE);
        }

        if (! file_put_contents($this->input->getOption('file'), (string) $version, LOCK_EX)) {
            throw new WriteException(self::WRITE_FAILURE);
        }
    }

    /** {@inheritdoc} */
    public function destroyVersion(): void
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw new DestroyException(self::NOT_INITIALIZED);
        }

        if (! unlink($this->input->getOption('file'))) {
            throw new DestroyException(self::DESTROY_FAILURE);
        }
    }
}
