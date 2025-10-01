<?php

function decryptBackup($encryptedFile, $decryptionKey, $outputFile) {
    $command = "openssl enc -d -aes-256-cbc -in $encryptedFile -out $outputFile -k $decryptionKey";
    exec($command, $output, $returnVar);

    if ($returnVar !== 0) {
        throw new Exception("Erreur lors du déchiffrement : " . implode("\n", $output));
    }
}

// Exemple d'utilisation
$encryptedFile = 'ProjetCybersecu/src/backup.txt';
$decryptionKey = 'AES-206';
$outputFile = 'ProjetCybersecu/src/backup.sql';

try {
    decryptBackup($encryptedFile, $decryptionKey, $outputFile);
    echo "Déchiffrement réussi.\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>