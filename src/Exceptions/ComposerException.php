<?php

namespace PHLAK\SemVerCLI\Exceptions;

use RuntimeException;

class ComposerException extends RuntimeException
{
    public static function notInitialized(): self
    {
        return new self('Composer is not initialized, run composer init first');
    }
}
