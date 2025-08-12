#!/bin/bash

# Skrypt wdrożenia Laravel na współdzielony hosting przez FTP
# Autor: Assistant
# Użycie: ./deploy.sh

set -e  # Zatrzymaj skrypt przy błędzie

echo "🚀 Rozpoczynam wdrażanie aplikacji Laravel..."

# Konfiguracja
PROJECT_NAME="farmaceutyczna-platforma"
BUILD_DIR="build_for_deploy"
PUBLIC_DIR="$BUILD_DIR/public_html"
APP_DIR="$BUILD_DIR/app"

# Kolory dla lepszej czytelności
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funkcja do logowania
log() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Sprawdź czy jesteśmy w katalogu projektu
if [ ! -f "artisan" ]; then
    error "Musisz być w katalogu projektu Laravel (gdzie jest plik artisan)"
    exit 1
fi

# Utwórz katalogi budowania
log "Tworzę katalogi do wdrożenia..."
rm -rf "$BUILD_DIR"
mkdir -p "$PUBLIC_DIR"
mkdir -p "$APP_DIR"

# Instalacja zależności produkcyjnych
log "Instaluję zależności produkcyjne..."
composer install --optimize-autoloader --no-dev --quiet

# Budowanie assets
log "Buduję assets (CSS/JS)..."
npm run build --silent

# Kopiowanie plików aplikacji (poza public_html)
log "Kopiuję pliki aplikacji..."
cp -r app "$APP_DIR/"
cp -r bootstrap "$APP_DIR/"
cp -r config "$APP_DIR/"
cp -r database "$APP_DIR/"
# cp -r lang "$APP_DIR/"  # Katalog lang nie istnieje w tym projekcie
cp -r resources "$APP_DIR/"
cp -r routes "$APP_DIR/"
cp -r storage "$APP_DIR/"
cp -r vendor "$APP_DIR/"
cp artisan "$APP_DIR/"
cp composer.json "$APP_DIR/"
cp composer.lock "$APP_DIR/"

# Kopiowanie plików publicznych
log "Kopiuję pliki publiczne..."
cp -r public/* "$PUBLIC_DIR/"

# Modyfikacja index.php dla współdzielonego hostingu
log "Modyfikuję index.php dla współdzielonego hostingu..."
cat > "$PUBLIC_DIR/index.php" << 'EOF'
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ścieżka do katalogu nadrzędnego (poza public_html)
require __DIR__.'/../app/vendor/autoload.php';
$app = require_once __DIR__.'/../app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
EOF

# Utworzenie .htaccess w głównym katalogu
log "Tworzę .htaccess..."
cat > "$BUILD_DIR/.htaccess" << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public_html/$1 [L]
</IfModule>
EOF

# Utworzenie .htaccess w public_html
log "Modyfikuję .htaccess w public_html..."
cat > "$PUBLIC_DIR/.htaccess" << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
EOF

# Ustawienie uprawnień
log "Ustawiam uprawnienia..."
chmod -R 755 "$APP_DIR/storage"
chmod -R 755 "$APP_DIR/bootstrap/cache"
chmod -R 644 "$APP_DIR/storage/logs/*.log" 2>/dev/null || true

# Utworzenie pliku .env.example
log "Tworzę .env.example..."
cat > "$APP_DIR/.env.example" << 'EOF'
APP_NAME="Farmaceutyczna Platforma"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://twoja-domena.lh.pl

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=twoja_baza
DB_USERNAME=twoj_uzytkownik
DB_PASSWORD=twoje_haslo

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
EOF

# Utworzenie instrukcji wdrożenia
log "Tworzę instrukcję wdrożenia..."
cat > "$BUILD_DIR/INSTRUKCJA_WDROZENIA.txt" << 'EOF'
🚀 INSTRUKCJA WDROŻENIA LARAVEL NA LH.PL

1. POŁĄCZENIE FTP:
   - Host: twoja-domena.lh.pl
   - Użytkownik: twoj_uzytkownik
   - Hasło: twoje_haslo
   - Port: 21 (lub 22 dla SFTP)

2. STRUKTURA NA SERWERZE:
   
   KATALOG GŁÓWNY (np. /home/uzytkownik/):
   ├── app/                    # Wszystkie pliki z katalogu app/
   ├── public_html/            # Główny katalog publiczny
   └── .htaccess              # Reguły przepisywania URL

3. KROKI WDROŻENIA:
   
   a) Wrzuć cały katalog 'app' do katalogu głównego na serwerze
   b) Wrzuć cały katalog 'public_html' do katalogu głównego na serwerze
   c) Wrzuć plik '.htaccess' do katalogu głównego na serwerze
   
4. KONFIGURACJA:
   
   a) Skopiuj .env.example na .env
   b) Edytuj .env i ustaw:
      - Dane bazy danych
      - APP_URL
      - APP_KEY (wygeneruj przez panel)
   
5. UPRAWNIENIA:
   
   Ustaw uprawnienia na:
   - storage/: 755
   - bootstrap/cache/: 755
   - storage/logs/: 755
   
6. MIGRACJE:
   
   Uruchom migracje przez panel lh.pl lub przez SSH (jeśli dostępne):
   php artisan migrate
   
7. CACHE:
   
   Wyczyść i zoptymalizuj cache:
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

8. SPRAWDZENIE:
   
   Otwórz stronę w przeglądarce i sprawdź czy działa.

⚠️  WAŻNE:
- Nie wrzucaj plików .git, node_modules, .env
- Upewnij się że ścieżki w index.php są poprawne
- Sprawdź czy hosting obsługuje PHP 8.2+
- Sprawdź czy mod_rewrite jest włączony

📞 WSPARCIE:
W razie problemów sprawdź logi w storage/logs/
EOF

# Utworzenie skryptu automatyzacji
log "Tworzę skrypt automatyzacji..."
cat > "$BUILD_DIR/upload.sh" << 'EOF'
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
EOF

echo "Upload katalogu public_html..."
ftp -n $FTP_HOST << EOF
user $FTP_USER $FTP_PASS
cd $FTP_DIR
prompt
mput public_html/*
bye
EOF

echo "Upload .htaccess..."
ftp -n $FTP_HOST << EOF
user $FTP_USER $FTP_PASS
cd $FTP_DIR
prompt
put .htaccess
bye
EOF

echo "✅ Upload zakończony!"
EOF

chmod +x "$BUILD_DIR/upload.sh"

# Podsumowanie
echo ""
echo "${BLUE}================================${NC}"
echo "${GREEN}✅ WDROŻENIE PRZYGOTOWANE!${NC}"
echo "${BLUE}================================${NC}"
echo ""
echo "${YELLOW}Katalogi do wdrożenia:${NC}"
echo "  📁 $APP_DIR/ -> katalog główny na serwerze"
echo "  📁 $PUBLIC_DIR/ -> katalog główny na serwerze"
echo "  📄 $BUILD_DIR/.htaccess -> katalog główny na serwerze"
echo ""
echo "${YELLOW)Następne kroki:${NC}"
echo "  1. 📤 Wrzuć pliki przez FTP"
echo "  2. ⚙️  Skonfiguruj .env"
echo "  3. 🔑 Wygeneruj APP_KEY"
echo "  4. 🗄️  Uruchom migracje"
echo "  5. 🚀 Sprawdź działanie"
echo ""
echo "${BLUE}Szczegółowe instrukcje w: $BUILD_DIR/INSTRUKCJA_WDROZENIA.txt${NC}"
echo "${BLUE}Skrypt automatyzacji: $BUILD_DIR/upload.sh${NC}"
echo ""
echo "${GREEN}🎉 Gotowe do wdrożenia!${NC}"
