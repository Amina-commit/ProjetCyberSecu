<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:dump-encrypt',
    description: 'Sauvegarde et chiffre un fichier spécifié.',
)]
class DumpEncryptCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('input', InputArgument::REQUIRED, '')
            ->addArgument('output', InputArgument::REQUIRED, '')
            ->addOption('key', null, InputOption::VALUE_REQUIRED, 'AES-206', 'AES-206');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFile = $input->getArgument('input');
        $outputFile = $input->getArgument('output');
        $key = $input->getOption('key');

        if (!file_exists($inputFile)) {
            $io->error('Le fichier d\'entrée n\'existe pas.');
            return Command::FAILURE;
        }

        // Lire le contenu du fichier
        $data = file_get_contents($inputFile);

        // Chiffrement
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

        // Stocker le vecteur d'initialisation avec les données chiffrées
        file_put_contents($outputFile, base64_encode($iv . $encryptedData));

        $io->success('Fichier chiffré avec succès : ' . $outputFile);

        return Command::SUCCESS;
    }
}


