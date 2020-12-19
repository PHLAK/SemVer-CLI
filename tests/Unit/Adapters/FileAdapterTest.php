<?php

namespace Tests\Unit\Adapters;

use PHLAK\SemVer\Version;
use PHLAK\SemVerCLI\Adapters\FileAdapter;
use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;

/** @covers \PHLAK\SemVerCLI\Adapters\FileAdapter */
class FileAdapterTest extends TestCase
{
    protected const DATA_DIR = __DIR__ . '/../../_data';
    protected const VERSION_FILE = 'VERSION';

    /** @var FileAdapter */
    protected $adapter;

    protected function setUp(): void
    {
        chdir(self::DATA_DIR);

        /** @var InputInterface&MockObject $input */
        $input = $this->createMock(InputInterface::class);
        $input->expects($this->any())->method('getOption')
            ->with('file')->willReturn(self::VERSION_FILE);

        $this->adapter = new FileAdapter($input);
    }

    protected function tearDown(): void
    {
        foreach ([self::VERSION_FILE, '.version'] as $versionFile) {
            if (is_file($versionFile)) {
                unlink($versionFile);
            }
        }
    }

    /** @test */
    public function it_can_initialize_the_version_file(): void
    {
        $this->adapter->initializeVersion(new Version('1.3.37'));

        $this->assertStringEqualsFile(self::VERSION_FILE, '1.3.37');
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
    public function it_can_read_from_the_version(): void
    {
        file_put_contents(self::VERSION_FILE, '1.3.37');

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
        file_put_contents(self::VERSION_FILE, '1.3.3.7');

        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Failed to parse version string: 1.3.3.7');

        $this->adapter->readVersion();
    }

    /** @test */
    public function it_can_write_to_the_version(): void
    {
        file_put_contents(self::VERSION_FILE, '1.3.37');

        $this->adapter->writeVersion(new Version('4.2.42'));

        $this->assertStringEqualsFile(self::VERSION_FILE, '4.2.42');
    }

    /** @test */
    public function it_throws_an_exception_during_write_when_not_initialized(): void
    {
        $this->expectException(SemanticVersionException::class);
        $this->expectExceptionMessage('Semantic versioning is not intialized');

        $this->adapter->writeVersion(new Version('1.3.37'));
    }

    /** @test */
    public function it_can_destroy_the_version_file(): void
    {
        file_put_contents(self::VERSION_FILE, '1.3.37');

        $this->adapter->destroyVersion();

        $this->assertFileDoesNotExist(self::VERSION_FILE);
    }
}
