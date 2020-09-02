<?php

namespace PHLAK\SemVerCLI\Adapters;

use JsonException;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use PHLAK\SemVerCLI\Exceptions\DestroyException;
use PHLAK\SemVerCLI\Exceptions\InitializationException;
use PHLAK\SemVerCLI\Exceptions\ReadException;
use PHLAK\SemVerCLI\Exceptions\WriteException;
use RuntimeException;
use stdClass;
use Symfony\Component\Console\Input\InputInterface;

class ComposerAdapter implements AdapterInterface
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
        $composer = $this->readComposer();

        if ($composer->version !== null) {
            throw new InitializationException('Semantic versioning already initialized');
        }

        $composer->version = (string) $version;

        $this->writeComposer($composer);
    }

    /** {@inheritdoc} */
    public function readVersion(): Version
    {
        $composer = $this->readComposer();

        if ($composer->version === null) {
            throw new ReadException('Semantic versioning is not intialized');
        }

        try {
            return new Version($composer->version);
        } catch (InvalidVersionException $exception) {
            throw new ReadException('Failed to parse version from composer file');
        }
    }

    /** {@inheritdoc} */
    public function writeVersion(Version $version): void
    {
        $composer = $this->readComposer();

        if ($composer->version === null) {
            throw new WriteException('Semantic versioning is not intialized');
        }

        $composer->version = (string) $version;

        $this->writeComposer($composer);
    }

    /** {@inheritdoc} */
    public function destroyVersion(): void
    {
        $composer = $this->readComposer();

        if (! isset($composer->version)) {
            throw new DestroyException('Semantic versioning is not intialized');
        }

        unset($composer->version);

        $this->writeComposer($composer);
    }

    /**
     * Get the contents of the composer file as an ojbect.
     *
     * @throws RuntimeException
     * @throws JsonException
     */
    private function readComposer(): stdClass
    {
        if (! file_exists($this->input->getOption('composer'))) {
            throw new ReadException('Composer is not initialized, run composer init first');
        }

        return json_decode(file_get_contents(
            $this->input->getOption('composer')
        ), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Write an object to the composer file.
     *
     * @throws WriteException
     * @throws JsonException
     */
    private function writeComposer(stdClass $contents): void
    {
        if (! file_exists($this->input->getOption('composer'))) {
            throw new WriteException('Composer is not initialized, run composer init first');
        }

        file_put_contents(
            $this->input->getOption('composer'),
            json_encode($contents, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            LOCK_EX
        );
    }
}
