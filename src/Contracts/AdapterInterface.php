<?php

namespace SemVerCli\Contracts;

use PHLAK\SemVer\Version;

interface AdapterInterface
{
    /**
     * Initialize the version storage.
     *
     * @throws \SemVerCli\Exceptions\InitializationException
     */
    public function initializeVersion(Version $version): void;

    /**
     * Get the current version from storage.
     *
     * @throws \SemVerCli\Exceptions\ReadException
     */
    public function readVersion(): Version;

    /**
     * Write a new version to stroage.
     *
     * @throws \SemVerCli\Exceptions\WriteException
     */
    public function writeVersion(Version $version): void;

    /**
     * Tears down the version storage.
     *
     * @throws \SemVerCli\Exceptions\DestroyException
     */
    public function destroyVersion(): void;
}
