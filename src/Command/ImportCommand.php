<?php

namespace App\Command;

use App\Services\Media\MediaManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'pam:import',
    description: 'Auto import files to the database',
)]
class ImportCommand extends Command
{
    #[Required]
    public MediaManager $mediaManager;

    protected function configure(): void
    {
        $this
            ->addArgument(name: 'directory', mode: InputArgument::REQUIRED, description: 'Directory to import')
            ->addOption(name: 'loop', shortcut: "l", mode: InputOption::VALUE_NONE, description: 'Keep running after import')
            ->addOption(name: 'cool-down', mode: InputOption::VALUE_OPTIONAL, description: 'time sleeping in seconds before re-run scan', default: 30);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $io = new SymfonyStyle($input, $output);
        $directory = $input->getArgument('directory');

        $loop = $input->getOption('loop');
        do {
            $this->mediaManager->import($directory);
            if ($loop) {
                sleep($input->getOption('cool-down'));
            }
        } while ($loop);

        $io->success('Imported');

        return Command::SUCCESS;
    }
}
