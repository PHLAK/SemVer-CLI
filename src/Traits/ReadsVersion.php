<?php

namespace SemVerCli\Traits;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use PHLAK\SemVer\Version;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

trait ReadsVersion
{
    /**
     * Get the current verson from storage.
     *
     * @throws RuntimeException
     */
    protected function readVersion(InputInterface $input): Version
    {
        if (! file_exists($input->getOption('file'))) {
            throw new RuntimeException('Semantic versioning is not intialized in this directory');
        }

        if (! is_readable($input->getOption('file'))) {
            throw new RuntimeException('Version file exists but is not readbale');
        }

        if (! $contents = @file_get_contents($input->getOption('file'))) {
            throw new RuntimeException('Failed reading from version from');
        }

        try {
            return new Version($contents);
        } catch (InvalidVersionException $exception) {
            throw new RuntimeException('Failed to parse version from version file');
        }
    }
}
