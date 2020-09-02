<?php

namespace PHLAK\SemVerCLI\Exceptions;

use RuntimeException;

class SemanticVersionException extends RuntimeException
{
    public static function alreadyInitialized(): self
    {
        return new static('Semantic versioning already initialized');
    }

    public static function notInitialized(): self
    {
        return new static('Semantic versioning is not intialized');
    }

    public static function parseFailure(string $version): self
    {
        return new static(sprintf('Failed to parse version string: %s', $version));
    }

    public static function destroyFailure(): self
    {
        return new static('Failed to disable semantic versioning');
    }
}
