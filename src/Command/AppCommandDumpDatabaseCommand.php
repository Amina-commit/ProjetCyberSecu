<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class DumpDatabaseCommand extends Command
{
    protected static $defaultName = 'app:dump-database';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Dump the database to a SQL file')
            ->addOption('output', null, InputOption::VALUE_REQUIRED, 'Output file path', 'backup.sql');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputFile = $input->getOption('output');
        $connection = $this->entityManager->getConnection();
        $params = $connection->getParams();

        $command = sprintf(
            'mysqldump -u %s -p%s %s > %s',
            $params['login5732'],
            $params['dTNIOmZjveqabQG'],
            $params['bdmamie'],
            $outputFile
        );

        system($command, $returnVar);

        if ($returnVar !== 0) {
            $output->writeln('<error>Failed to dump the database.</error>');
            return Command::FAILURE;
        }

        $output->writeln('<info>Database dumped successfully to ' . $outputFile . '</info>');
        return Command::SUCCESS;
    }
}
