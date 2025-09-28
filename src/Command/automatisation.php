<?php

function hashFile($filePath) {
    return hash_file('sha256', $filePath);
}

function sendFile($localFilePath, $remoteFilePath, $remoteUser, $remoteHost) {
    $command = "scp $localFilePath $remoteUser@$remoteHost:$remoteFilePath";
    exec($command, $output, $returnVar);
    return $returnVar === 0; // Retourne true si l'envoi a réussi
}

function verifyFile($remoteFilePath, $remoteHashPath, $remoteUser, $remoteHost) {
    $command = "ssh $remoteUser@$remoteHost 'sha256sum $remoteFilePath > $remoteFilePath.sha256 && diff $remoteFilePath.sha256 $remoteHashPath'";
    exec($command, $output, $returnVar);
    return $returnVar === 0; // Retourne true si les fichiers sont identiques
}

// Chemins des fichiers
$localFilePath = '/ProjetCybersecu/src/backup.txt';
$localHashPath = '/ProjetCybersecu/src/hache.txt.sha256';
$remoteFilePath = '/ProjetCybersecu/src/backup.txt';
$remoteHashPath = '/ProjetCybersecu/src/hache.txt.sha256';

// Informations de connexion
$remoteUser = 'user1';  
$remoteHost = '10.23.216.133';

// Hachage du fichier local
file_put_contents($localHashPath, hashFile($localFilePath));

// Envoi du fichier et du hachage
if (sendFile($localFilePath, $remoteFilePath, $remoteUser, $remoteHost) &&
    sendFile($localHashPath, $remoteHashPath, $remoteUser, $remoteHost)) {
    
    echo "Fichiers envoyés avec succès.\n";

    // Vérification de l'intégrité du fichier sur le serveur distant
    if (verifyFile($remoteFilePath, $remoteHashPath, $remoteUser, $remoteHost)) {
        echo "Le fichier reçu est identique à celui envoyé.\n";
    } else {
        echo "Le fichier reçu est différent de celui envoyé.\n";
    }
} else {
    echo "Erreur lors de l'envoi des fichiers.\n";
}  
?>
