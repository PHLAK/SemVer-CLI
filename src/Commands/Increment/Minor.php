<?php

namespace SemVerCli\Commands\Increment;

use SemVerCli\Commands\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minor extends Command
{
    public function configure(): void
    {
        $this->setName('increment:minor');
        $this->setDescription('Increment the minor version by one');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();
        $this->adapter->writeVersion($version->incrementMinor());

        $output->writeln(
            sprintf('Semantic version incremented to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
