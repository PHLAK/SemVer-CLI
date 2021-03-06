<?php

namespace PHLAK\SemVerCLI\Exceptions;

use RuntimeException;

class FileException extends RuntimeException
{
    public static function notReadable(string $file): self
    {
        return new self(sprintf('Unable to read file: %s', realpath($file)));
    }

    public static function notWriteable(string $file): self
    {
        return new self(sprintf('Unable to write to file: %s', realpath($file)));
    }
}
