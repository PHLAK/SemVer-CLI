<?php

namespace SemVerCli\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    protected const CONFIG_FILE = 'semver.config.php';

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('file') !== false) {
            return;
        }

        if (is_readable(self::CONFIG_FILE)) {
            $config = require self::CONFIG_FILE;
        }

        $input->setOption('file', $config['file_name'] ?? 'VERSION');
    }
}
