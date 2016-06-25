<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;

abstract class BaseCommand extends Command {

    /** @var array Semantic version data file */
    protected $semverFile = '.semver';

    protected function readVersionFromDisk() {
        if (! $contents = @file_get_contents($this->semverFile)) {
            throw new RuntimeException('Semantic versioning not intialized in this directory');
        }
        return unserialize($contents);
    }

    protected function writeVersionToDisk(SemVer $semver) {
        if (file_put_contents($this->semverFile, serialize($semver), LOCK_EX) === false) {
            throw new RuntimeException('Failed to write data to disk');
        }
        return true;
    }

    protected function getMethodFromProperty($prefix, $property) {
        $semver = $this->readVersionFromDisk();
        $method = $prefix . implode('', array_map('ucfirst', explode('-', $property)));
        if (! method_exists($semver, $method)) {
            throw new InvalidArgumentException('Property "' . $property . '" is not defined');
        }
        return $method;
    }

}

