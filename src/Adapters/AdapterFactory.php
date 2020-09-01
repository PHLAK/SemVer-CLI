<?php

namespace PHLAK\SemVerCLI\Adapters;

use PHLAK\SemVerCLI\Contracts\AdapterInterface;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

class AdapterFactory
{
    public static function make(InputInterface $input): AdapterInterface
    {
        switch ($input->getOption('adapter')) {
            case 'file':
                return new FileAdapter($input);

            case 'composer':
                return new ComposerAdapter($input);

            default:
                throw new RuntimeException('Invalid adapter specified');
        }
    }
}
