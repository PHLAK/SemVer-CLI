<?php

namespace PHLAK\SemVerCLI\Contracts;

use PHLAK\SemVer\Version;

interface AdapterInterface
{
    /**
     * Initialize the version storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\InitializationException
     */
    public function initializeVersion(Version $version): void;

    /**
     * Get the current version from storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\ReadException
     */
    public function readVersion(): Version;

    /**
     * Write a new version to stroage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\WriteException
     */
    public function writeVersion(Version $version): void;

    /**
     * Tears down the version storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\DestroyException
     */
    public function destroyVersion(): void;
}
