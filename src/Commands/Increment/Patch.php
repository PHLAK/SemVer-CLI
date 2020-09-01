<?php

namespace PHLAK\SemVerCLI\Commands\Increment;

use PHLAK\SemVerCLI\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Patch extends Command
{
    public function configure(): void
    {
        $this->setName('increment:patch');
        $this->setDescription('Increment the patch version by one');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();
        $this->adapter->writeVersion($version->incrementPatch());

        $output->writeln(
            sprintf('Semantic version incremented to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
