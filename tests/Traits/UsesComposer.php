<?php

namespace Tests\Traits;

trait UsesComposer
{
    /** Initialize Composer in the test directory. */
    protected function initializeComposer(): void
    {
        copy(
            __DIR__ . '/../_data/skeleton/composer.json',
            __DIR__ . '/../_data/composer.json'
        );
    }

    /** Remove the composer.json file from the test directory. */
    protected function destroyComposer(): void
    {
        $composerFile = __DIR__ . '/../_data/composer.json';

        if (is_file($composerFile)) {
            unlink($composerFile);
        }
    }
}
