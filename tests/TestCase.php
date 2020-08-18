<?php

namespace Tests;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use SemVerCli\Bootstrap\AppManager;
use Symfony\Component\Console\Application;

class TestCase extends PHPUnitTestCase
{
    protected const DATA_DIR = __DIR__ . '/_data';

    protected Application $app;

    public function setUp(): void
    {
        chdir(self::DATA_DIR);

        $this->container = (new ContainerBuilder)->addDefinitions(
            ...glob(dirname(__DIR__) . '/config/*.php')
        )->build();

        $this->app = new Application('Semantic versioning helper', 'TEST');

        (new AppManager($this->container, $this->app))();
    }

    public function tearDown(): void
    {
        $versionFilePath = sprintf('%s/%s', self::DATA_DIR, 'VERSION');

        if (file_exists($versionFilePath)) {
            unlink($versionFilePath);
        }
    }
}
