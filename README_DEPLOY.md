# 🚀 Wdrożenie Laravel na LH.PL

## Szybki start

### 1. Uruchom skrypt przygotowania

```bash
cd farmaceutyczna-platforma
chmod +x deploy.sh
./deploy.sh
```

### 2. Co zostanie utworzone

Skrypt utworzy katalog `build_for_deploy/` zawierający:

```
build_for_deploy/
├── app/                    # Pliki aplikacji (poza public_html)
├── public_html/            # Pliki publiczne
├── .htaccess              # Reguły URL
├── INSTRUKCJA_WDROZENIA.txt # Szczegółowe instrukcje
└── upload.sh              # Skrypt automatyzacji
```

### 3. Struktura na serwerze

```
/home/uzytkownik/          # Katalog główny na serwerze
├── app/                   # Wszystkie pliki z katalogu app/
├── public_html/           # Główny katalog publiczny
└── .htaccess             # Reguły przepisywania URL
```

## 📤 Upload przez FTP

### Opcja 1: Automatyczny upload

1. Edytuj `build_for_deploy/upload.sh`
2. Ustaw dane FTP
3. Uruchom: `./upload.sh`

### Opcja 2: Ręczny upload przez FileZilla

1. Pobierz [FileZilla](https://filezilla-project.org/)
2. Połącz się z serwerem
3. Wrzuć katalogi:
   - `app/` → katalog główny na serwerze
   - `public_html/` → katalog główny na serwerze
   - `.htaccess` → katalog główny na serwerze

## ⚙️ Konfiguracja po wdrożeniu

### 1. Plik .env

```bash
# Na serwerze
cp .env.example .env
nano .env
```

Ustaw:
- `APP_URL=https://twoja-domena.lh.pl`
- Dane bazy danych
- `APP_ENV=production`
- `APP_DEBUG=false`

### 2. Klucz aplikacji

```bash
php artisan key:generate
```

### 3. Migracje

```bash
php artisan migrate
```

### 4. Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Uprawnienia

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 🔧 Rozwiązywanie problemów

### Błąd 500
- Sprawdź logi w `storage/logs/`
- Sprawdź uprawnienia na `storage/` i `bootstrap/cache/`
- Sprawdź czy `.env` jest poprawnie skonfigurowany

### Błąd 404
- Sprawdź czy `.htaccess` jest w głównym katalogu
- Sprawdź czy `mod_rewrite` jest włączony na hostingu
- Sprawdź ścieżki w `index.php`

### Błąd bazy danych
- Sprawdź dane połączenia w `.env`
- Sprawdź czy baza istnieje
- Sprawdź uprawnienia użytkownika bazy

## 📋 Wymagania serwera

- PHP 8.2+
- MySQL 5.7+ lub MariaDB 10.2+
- Rozszerzenia PHP: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`
- Moduł Apache: `mod_rewrite`

## 🆘 Wsparcie

W razie problemów:
1. Sprawdź logi w `storage/logs/`
2. Sprawdź instrukcję w `INSTRUKCJA_WDROZENIA.txt`
3. Sprawdź dokumentację Laravel
4. Skontaktuj się z supportem lh.pl

## 🎯 Najczęstsze błędy

| Błąd | Rozwiązanie |
|------|-------------|
| "Class not found" | Sprawdź czy `vendor/` został wrzucony |
| "Permission denied" | Ustaw uprawnienia 755 na `storage/` |
| "Database connection failed" | Sprawdź dane w `.env` |
| "404 Not Found" | Sprawdź `.htaccess` i `mod_rewrite` |

---

**Powodzenia z wdrożeniem! 🚀**
