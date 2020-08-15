<?php

namespace SemVerCli\Commands;

use PHLAK\SemVer\Version;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;

abstract class BaseCommand extends Command
{
    /** @const Semantic version data file */
    public const VERSION_FILE = 'VERSION';

    /**
     * Get the SemVer object from the data file.
     *
     * @throws RuntimeException
     */
    protected function readVersionFromDisk(): Version
    {
        if (! $contents = file_get_contents(self::VERSION_FILE)) {
            throw new RuntimeException('Semantic versioning not intialized in this directory');
        }

        return unserialize($contents);
    }

    /**
     * Write a Version object to the data file.
     *
     * @throws RuntimeException
     */
    protected function writeVersionToDisk(Version $version): void
    {
        if (file_put_contents(self::VERSION_FILE, serialize($version), LOCK_EX) === false) {
            throw new RuntimeException('Failed to write data to disk');
        }
    }
}
