<?php

namespace PHLAK\SemVerCLI\Adapters;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use PHLAK\SemVerCLI\Exceptions\FileException;
use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
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
            throw SemanticVersionException::alreadyInitialized();
        }

        if (! touch($this->input->getOption('file'))) {
            throw new SemanticVersionException('Failed to create the version file');
        }

        $this->writeVersion($version);
    }

    /** {@inheritdoc} */
    public function readVersion(): Version
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw SemanticVersionException::notInitialized();
        }

        if (! is_readable($this->input->getOption('file'))) {
            throw FileException::notReadable($this->input->getOption('file'));
        }

        $contents = @file_get_contents($this->input->getOption('file'));

        try {
            return new Version($contents);
        } catch (InvalidVersionException $exception) {
            throw SemanticVersionException::parseFailure($contents);
        }
    }

    /** {@inheritdoc} */
    public function writeVersion(Version $version): void
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw SemanticVersionException::notInitialized();
        }

        if (! is_writable($this->input->getOption('file'))) {
            throw FileException::notWriteable($this->input->getOption('file'));
        }

        file_put_contents($this->input->getOption('file'), (string) $version, LOCK_EX);
    }

    /** {@inheritdoc} */
    public function destroyVersion(): void
    {
        if (! file_exists($this->input->getOption('file'))) {
            throw SemanticVersionException::notInitialized();
        }

        if (! unlink($this->input->getOption('file'))) {
            throw SemanticVersionException::destroyFailure();
        }
    }
}
