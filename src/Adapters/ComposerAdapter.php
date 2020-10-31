<?php

namespace PHLAK\SemVerCLI\Adapters;

use Composer\Json\JsonFile;
use JsonException;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use PHLAK\SemVerCLI\Exceptions\ComposerException;
use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
use stdClass;
use Symfony\Component\Console\Input\InputInterface;

class ComposerAdapter implements AdapterInterface
{
    /** @var JsonFile */
    protected $composer;

    /** Create a new file adapter. */
    public function __construct(InputInterface $input)
    {
        $this->composer = new JsonFile($input->getOption('composer'));
    }

    /** {@inheritdoc} */
    public function initializeVersion(Version $version): void
    {
        $composer = $this->readComposer();

        if (isset($composer->version)) {
            throw SemanticVersionException::alreadyInitialized();
        }

        $composer->version = (string) $version;

        $this->writeComposer($composer);
    }

    /** {@inheritdoc} */
    public function readVersion(): Version
    {
        $composer = $this->readComposer();

        if (! isset($composer->version)) {
            throw SemanticVersionException::notInitialized();
        }

        try {
            return new Version((string) $composer->version);
        } catch (InvalidVersionException $exception) {
            throw SemanticVersionException::parseFailure((string) $composer->version);
        }
    }

    /** {@inheritdoc} */
    public function writeVersion(Version $version): void
    {
        $composer = $this->readComposer();

        if (! isset($composer->version)) {
            throw SemanticVersionException::notInitialized();
        }

        $composer->version = (string) $version;

        $this->writeComposer($composer);
    }

    /** {@inheritdoc} */
    public function destroyVersion(): void
    {
        $composer = $this->readComposer();

        if (! isset($composer->version)) {
            throw SemanticVersionException::notInitialized();
        }

        unset($composer->version);

        $this->writeComposer($composer);
    }

    /**
     * Get the contents of the composer file as an ojbect.
     *
     * @throws ComposerException
     */
    private function readComposer(): stdClass
    {
        if (! $this->composer->exists()) {
            throw ComposerException::notInitialized();
        }

        return $this->toJsonObect($this->composer->read());
    }

    /**
     * Write an object to the composer file.
     *
     * @throws ComposerException
     */
    private function writeComposer(stdClass $contents): void
    {
        if (! $this->composer->exists()) {
            throw ComposerException::notInitialized();
        }

        $this->composer->write(
            JsonFile::parseJson(json_encode($contents))
        );
    }

    /**
     * Convert a value to a JSON decoded object.
     *
     * @throws JsonException
     */
    private function toJsonObect($value): object
    {
        return json_decode(json_encode($value), false, 512, JSON_THROW_ON_ERROR);
    }
}
