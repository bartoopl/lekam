#!/bin/bash

# Skrypt do automatycznego uploadu przez FTP
# Użycie: ./upload.sh

echo "📤 Rozpoczynam upload przez FTP..."

# Konfiguracja FTP
FTP_HOST="twoja-domena.lh.pl"
FTP_USER="twoj_uzytkownik"
FTP_PASS="twoje_haslo"
FTP_DIR="/home/uzytkownik/"

# Upload plików
echo "Upload katalogu app..."
ftp -n $FTP_HOST << EOF
user $FTP_USER $FTP_PASS
cd $FTP_DIR
prompt
mput app/*
bye
