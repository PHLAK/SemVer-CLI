<?php

namespace PHLAK\SemVerCLI\Exceptions;

use RuntimeException;

class FileException extends RuntimeException
{
    public static function notReadable(string $file): self
    {
        return new static(sprintf('Unable to read file at %s', realpath($file)));
    }

    public static function notWriteable(string $file): self
    {
        return new static(sprintf('Unable to write to file at %s', realpath($file)));
    }
}
