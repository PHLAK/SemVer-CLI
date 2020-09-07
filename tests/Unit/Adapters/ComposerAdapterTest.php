<?php

namespace Tests\Unit\Adapters;

use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Adapters\ComposerAdapter;
use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Input\InputInterface;
use Tests\Traits;

/** @covers \PHLAK\SemVerCLI\Adapters\ComposerAdapter */
class ComposerAdapterTest extends TestCase
{
    use Traits\UsesComposer;

    protected const DATA_DIR = __DIR__ . '/../../_data';
    protected const COMPOSER_FILE = 'composer.json';

    /** @var ComposerAdapter */
    protected $adapter;

    public function setUp(): void
    {
        chdir(self::DATA_DIR);

        $this->initializeComposer();

        /** @var InputInterface&MockObject $input */
        $input = $this->createMock(InputInterface::class);
        $input->expects($this->any())->method('getOption')
            ->with('composer')->willReturn(self::COMPOSER_FILE);

        $this->adapter = new ComposerAdapter($input);
    }

    public function tearDown(): void
    {
        $this->destroyComposer();
    }

    /** @test */
    public function it_can_initialize_the_composer_version_property(): void
    {
        $this->adapter->initializeVersion(new Version('1.3.37'));

        $this->assertEquals('1.3.37', $this->getComposer()->version);
    }

    /** @test */
    public function it_throws_an_exception_during_initialization_when_already_initialized(): void
    {
        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Semantic versioning already initialized');

        $this->adapter->initializeVersion(new Version('1.3.37'));
        $this->adapter->initializeVersion(new Version('1.3.37'));
    }

    /** @test */
    public function it_can_read_the_composer_version_property(): void
    {
        $this->adapter->initializeVersion(new Version('1.3.37'));

        $version = $this->adapter->readVersion();

        $this->assertEquals('1.3.37', $version);
    }

    /** @test */
    public function it_throws_an_exception_during_read_when_not_initialized(): void
    {
        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Semantic versioning is not intialized');

        $this->adapter->readVersion();
    }

    /** @test */
    public function it_throws_an_exception_during_read_when_version_file_contains_an_invalid_version_string(): void
    {
        $composer = json_decode(file_get_contents(self::COMPOSER_FILE));
        $composer->version = '1.3.3.7';
        file_put_contents(self::COMPOSER_FILE, json_encode($composer));

        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Failed to parse version string: 1.3.3.7');

        $this->adapter->readVersion();
    }

    /** @test */
    public function it_can_write_to_the_composer_version_property(): void
    {
        $this->adapter->initializeVersion(new Version('1.3.37'));

        $this->adapter->writeVersion(new Version('4.2.42'));

        $this->assertEquals('4.2.42', $this->getComposer()->version);
    }

    /** @test */
    public function it_throws_an_exception_during_write_when_not_initialized(): void
    {
        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Semantic versioning is not intialized');

        $this->adapter->writeVersion(new Version('1.3.37'));
    }

    /** @test */
    public function it_can_destroy_the_composer_version_property(): void
    {
        $this->adapter->initializeVersion(new Version('1.3.37'));

        $this->adapter->destroyVersion();

        $this->assertObjectNotHasAttribute('version', $this->getComposer());
    }

    /** Get the Composer object. */
    private function getComposer(): stdClass
    {
        return json_decode(file_get_contents(self::COMPOSER_FILE), false, 512, JSON_THROW_ON_ERROR);
    }
}
