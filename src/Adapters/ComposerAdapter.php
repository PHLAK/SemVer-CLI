<?php

namespace PHLAK\SemVerCLI\Adapters;

use JsonException;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use PHLAK\SemVerCLI\Exceptions\ComposerException;
use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
use RuntimeException;
use stdClass;
use Symfony\Component\Console\Input\InputInterface;

class ComposerAdapter implements AdapterInterface
{
    protected const JSON_OPTIONS = JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

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
     * @throws RuntimeException
     * @throws JsonException
     */
    private function readComposer(): stdClass
    {
        if (! file_exists($this->input->getOption('composer'))) {
            throw ComposerException::notInitialized();
        }

        return json_decode(file_get_contents(
            $this->input->getOption('composer')
        ), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Write an object to the composer file.
     *
     * @throws SemanticVersionException
     * @throws JsonException
     */
    private function writeComposer(stdClass $contents): void
    {
        if (! file_exists($this->input->getOption('composer'))) {
            throw SemanticVersionException::destroyFailure();
        }

        file_put_contents(
            $this->input->getOption('composer'),
            json_encode($contents, self::JSON_OPTIONS),
            LOCK_EX
        );
    }
}
