<?php

namespace App\Command;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use phpseclib3\Net\SFTP;

// Charger la clé de chiffrement
$key = Key::loadFromAsciiSafeString(file_get_contents('encryption_key.txt'));

// Lire le contenu du fichier de sauvegarde
$backupFilePath = 'src/backup.sql';
$backupContent = file_get_contents($backupFilePath);

// Chiffrer le contenu
$encryptedContent = Crypto::encrypt($backupContent, $key);

// Enregistrer le contenu chiffré dans un fichier temporaire
$tempEncryptedFilePath = 'src/backup.txt';
file_put_contents($tempEncryptedFilePath, $encryptedContent);

// Informations de connexion au serveur distant
$sftpHost = 'localHost';
$sftpUsername = 'login5729';
$sftpPassword = 'WnpwrywDkOlxiez';
$remoteFilePath = '/backup.txt';

// Connexion SFTP
$sftp = new SFTP($sftpHost);
if (!$sftp->login($sftpUsername, $sftpPassword)) {
    throw new \Exception('Échec de la connexion SFTP.');
}

// Envoyer le fichier chiffré sur le serveur distant
if (!$sftp->put($remoteFilePath, $tempEncryptedFilePath, SFTP::SOURCE_LOCAL_FILE)) {
    throw new \Exception('Échec de l\'envoi du fichier sur le serveur distant.');
}

// Supprimer le fichier temporaire
unlink($tempEncryptedFilePath);

echo "Le fichier de sauvegarde chiffré a été envoyé avec succès sur le serveur distant.";
