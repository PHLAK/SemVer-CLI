<?php

namespace Tests\Unit\Exceptions;

use PHLAK\SemVerCLI\Exceptions\SemanticVersionException;
use Tests\TestCase;

/** @covers \PHLAK\SemVerCLI\Exceptions\SemanticVersionException */
class SemanticVersionExceptionTest extends TestCase
{
    /** @test */
    public function it_can_get_the_already_initialized_exception_message(): void
    {
        $exception = SemanticVersionException::alreadyInitialized();

        $this->assertEquals('Semantic versioning already initialized', $exception->getMessage());
    }

    /** @test */
    public function it_can_get_the_not_initialized_exception_message(): void
    {
        $exception = SemanticVersionException::notInitialized();

        $this->assertEquals('Semantic versioning is not intialized', $exception->getMessage());
    }

    /** @test */
    public function it_can_get_the_parse_failre_exception_message(): void
    {
        $exception = SemanticVersionException::parseFailure('1.3.3.7');

        $this->assertEquals('Failed to parse version string: 1.3.3.7', $exception->getMessage());
    }

    /** @test */
    public function it_can_get_the_destroy_failure_exception_message(): void
    {
        $exception = SemanticVersionException::destroyFailure();

        $this->assertEquals('Failed to disable semantic versioning', $exception->getMessage());
    }
}
