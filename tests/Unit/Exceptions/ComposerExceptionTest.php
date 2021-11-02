<?php

namespace Tests\Unit\Exceptions;

use PHLAK\SemVerCLI\Exceptions\ComposerException;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/** @covers \PHLAK\SemVerCLI\Exceptions\ComposerException */
class ComposerExceptionTest extends TestCase
{
    /** @test */
    public function it_can_construct_a_not_initialized_exception(): void
    {
        $exception = ComposerException::notInitialized();

        $this->assertEquals(
            'Composer is not initialized, run composer init first',
            $exception->getMessage()
        );
    }
}
