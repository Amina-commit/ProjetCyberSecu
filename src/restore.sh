#!/bin/bash

# Variables
REMOTE_SERVER="user1@10.23.216.133"
REMOTE_PATH="/home/user1/backup.sql.enc"
LOCAL_PATH="ProjetCybersecu/backup.sql"
DECRYPTION_KEY="AES-206"
DB_HOST="localhost"
DB_USER="login5732"
DB_PASSWORD="dTNIOmZjveqabQG"
DB_NAME="bdmamie"

# Transfert du fichier
scp $REMOTE_SERVER:$REMOTE_PATH $LOCAL_PATH
