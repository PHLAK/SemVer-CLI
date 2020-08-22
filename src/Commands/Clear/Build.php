<?php

namespace SemVerCli\Commands\Clear;

use SemVerCli\Traits\ReadsVersion;
use SemVerCli\Traits\WritesVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Build extends Command
{
    use ReadsVersion;
    use WritesVersion;

    protected function configure(): void
    {
        $this->setName('clear:build');
        $this->setDescription('Clear the build value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);
        $this->writeVersion($input, $version->setBuild(null));

        $output->writeln(
            sprintf('Build value has been cleared, version is now <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
