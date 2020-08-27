<?php

namespace SemVerCli\Commands\Clear;

use SemVerCli\Commands\Command;
use SemVerCli\Traits\ReadsVersion;
use SemVerCli\Traits\WritesVersion;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreRelease extends Command
{
    use ReadsVersion;
    use WritesVersion;

    protected function configure(): void
    {
        $this->setName('clear:pre-release');
        $this->setDescription('Clear the pre-release value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);

        $this->writeVersion($input, $version->setPreRelease(null));

        $output->writeln(
            sprintf('Pre-release value has been cleared, version is now <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
