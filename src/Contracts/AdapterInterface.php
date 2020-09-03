<?php

namespace PHLAK\SemVerCLI\Contracts;

use PHLAK\SemVer\Version;

interface AdapterInterface
{
    /**
     * Initialize the version storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\SemanticVersionException
     */
    public function initializeVersion(Version $version): void;

    /**
     * Get the current version from storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\SemanticVersionException
     */
    public function readVersion(): Version;

    /**
     * Write a new version to stroage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\SemanticVersionException
     */
    public function writeVersion(Version $version): void;

    /**
     * Tears down the version storage.
     *
     * @throws \PHLAK\SemVerCLI\Exceptions\SemanticVersionException
     */
    public function destroyVersion(): void;
}
