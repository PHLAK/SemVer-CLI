<?php

namespace SemVerCli\Traits;

use PHLAK\SemVer\Version;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

trait WritesVersion
{
    /**
     * Write the version to storage.
     *
     * @throws RuntimeException
     */
    protected function writeVersion(InputInterface $input, Version $version): void
    {
        if (! file_exists($input->getOption('file'))) {
            throw new RuntimeException('Semantic versioning is not intialized in this directory');
        }

        if (! is_writable($input->getOption('file'))) {
            throw new RuntimeException('Version file exists but is not writable');
        }

        if (! file_put_contents($input->getOption('file'), (string) $version, LOCK_EX)) {
            throw new RuntimeException('Failed writing to version file');
        }
    }
}
