<?php

namespace Tests\Unit\Adapters;

use PHLAK\SemVerCLI\Adapters\AdapterFactory;
use PHLAK\SemVerCLI\Adapters\ComposerAdapter;
use PHLAK\SemVerCLI\Adapters\FileAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

class AdapterFactoryTest extends TestCase
{
    /** @var InputInterface&MockObject */
    protected $input;

    public function setUp(): void
    {
        $this->input = $this->createMock(InputInterface::class);
    }

    /** @test */
    public function it_can_return_a_file_adapter(): void
    {
        $this->input
            ->expects($this->once())
            ->method('getOption')
            ->with('adapter')
            ->willReturn('file');

        $adapter = AdapterFactory::make($this->input);

        $this->assertInstanceOf(FileAdapter::class, $adapter);
    }

    /** @test */
    public function it_can_return_a_composer_adapter(): void
    {
        $this->input
            ->expects($this->exactly(2))
            ->method('getOption')
            ->withConsecutive(['adapter'], ['composer'])
            ->willReturnOnConsecutiveCalls('composer', 'compser.json');

        $adapter = AdapterFactory::make($this->input);

        $this->assertInstanceOf(ComposerAdapter::class, $adapter);
    }

    /** @test */
    public function it_throws_an_exception_for_an_invalid_adapter(): void
    {
        $this->input
            ->expects($this->once())
            ->method('getOption')
            ->with('adapter')
            ->willReturn('invalid');

        $this->expectException(RuntimeException::class);

        $adapter = AdapterFactory::make($this->input);
    }
}
