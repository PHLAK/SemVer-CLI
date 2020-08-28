<?php

namespace SemVerCli\Adapters;

use RuntimeException;
use SemVerCli\Contracts\AdapterInterface;
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
