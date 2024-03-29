<?php

namespace Tests\Unit\Bootstrap;

use PHLAK\SemVerCLI\Bootstrap\AppManager;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/** @covers \PHLAK\SemVerCLI\Bootstrap\AppManager */
class AppManagerTest extends TestCase
{
    /** @test */
    public function it_returns_the_bootstrapped_application(): void
    {
        /** @var ContainerInterface&MockObject $container */
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->with('commands')->willReturn([
            $testCommand = new Command('test-command'),
        ]);

        $application = new Application('Semantic versioning helper', '0.1.0');

        $app = (new AppManager($container, $application))();

        $this->assertTrue($app->getDefinition()->hasOption('adapter'));
        $this->assertTrue($app->getDefinition()->hasOption('composer'));
        $this->assertTrue($app->getDefinition()->hasOption('file'));
        $this->assertSame($testCommand, $app->get('test-command'));
    }
}
