<?php

namespace Tests\Unit\Exceptions;

use PHLAK\SemVerCLI\Exceptions\FileException;
use Tests\TestCase;

/** @covers \PHLAK\SemVerCLI\Exceptions\FileException */
class FileExceptionTest extends TestCase
{
    /** @test */
    public function it_can_get_the_not_readable_exception_message(): void
    {
        $exception = FileException::notReadable(__FILE__);

        $this->assertMatchesRegularExpression(
            '/^Unable to read file: .*\/FileExceptionTest.php$/',
            $exception->getMessage()
        );
    }

    /** @test */
    public function it_can_get_the_not_writable_exception_message(): void
    {
        $exception = FileException::notWriteable(__FILE__);

        $this->assertMatchesRegularExpression(
            '/^Unable to write to file: .*\/FileExceptionTest.php$/',
            $exception->getMessage()
        );
    }
}
