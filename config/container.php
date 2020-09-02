<?php

use PHLAK\SemVerCLI\Commands;
use Symfony\Component\Console\Application;

return [
    /* Array of commands. */
    'commands' => [
        // Initialize
        new Commands\Initialize,

        // Clear
        new Commands\Clear\PreRelease,
        new Commands\Clear\Build,

        // Get
        new Commands\Get\Version,
        new Commands\Get\Major,
        new Commands\Get\Minor,
        new Commands\Get\Patch,
        new Commands\Get\PreRelease,
        new Commands\Get\Build,

        // Increment
        new Commands\Increment\Major,
        new Commands\Increment\Minor,
        new Commands\Increment\Patch,

        // Set
        new Commands\Set\Version,
        new Commands\Set\Major,
        new Commands\Set\Minor,
        new Commands\Set\Patch,
        new Commands\Set\PreRelease,
        new Commands\Set\Build,

        // Destroy
        new Commands\Destroy,
    ],

    /* Container definitions. */
    Application::class => DI\create()->constructor('Semantic versioning helper', '0.1.0'),
];
