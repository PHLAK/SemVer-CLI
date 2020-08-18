<?php

namespace SemVerCli\Commands;

use PHLAK\SemVer\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

abstract class BaseCommand extends Command
{
    public const PREVIOUSLY_INITIALIZED = 200;
    public const VALUE_NOT_SET = 201;

    /**
     * Get the SemVer object from the data file.
     *
     * @throws RuntimeException
     */
    protected function readVersionFromDisk(InputInterface $input): Version
    {
        if (! $contents = @file_get_contents($input->getOption('file'))) {
            throw new RuntimeException('Semantic versioning not intialized in this directory');
        }

        return new Version($contents);
    }

    /**
     * Write a Version object to the data file.
     *
     * @throws RuntimeException
     */
    protected function writeVersionToDisk(InputInterface $input, Version $version): void
    {
        if (file_put_contents($input->getOption('file'), (string) $version, LOCK_EX) === false) {
            throw new RuntimeException('Failed to write data to disk');
        }
    }
}
