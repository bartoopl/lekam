# Plan integracji z API Autenti - Podpisywanie certyfikatów elektronicznie

## Kontekst

Celem jest integracja z API Autenti do elektronicznego podpisywania certyfikatów dla **techników farmacji**.

## Obecna implementacja

**Lokalizacja kodu:**
- `app/Services/CertificateService.php:17` - generowanie PDF
- `app/Http/Controllers/CertificateController.php` - kontroler certyfikatów
- PDF zapisywany lokalnie w `storage/public/certificates/`
- System już rozróżnia użytkowników `technik_farmacji` od `farmaceuta`

**Proces generowania:**
1. Użytkownik kończy kurs i zdaje test
2. System generuje PDF używając FPDI/TCPDF
3. PDF zapisywany w storage
4. Użytkownik może pobrać certyfikat

## API Autenti - Informacje

**Dostęp:**
- ✅ Autenti udostępnia REST API
- ✅ Dokumentacja: https://developers.autenti.com
- ✅ Wymaga pakietu API (płatne plany na https://autenti.com/pl/cennik/api)
- ✅ Minimum plan PRO z dostępem do API
- ❌ Brak gotowej oficjalnej biblioteki PHP (trzeba zrobić własną integrację)

**Kontakt:**
- Email: support@autenti.com
- Formularz: https://autenti.com/pl/contact-sales?hsLang=pl

## Co będzie potrzebne

### 1. Konto i dostępy Autenti
- [ ] Założenie konta Autenti z pakietem API (minimum PRO)
- [ ] Uzyskanie Client ID
- [ ] Uzyskanie Client Secret
- [ ] Konfiguracja webhooków (do odbierania statusów podpisów)

### 2. Implementacja techniczna

**Nowy serwis do komunikacji z API:**
```
app/Services/AutentiService.php
```
Funkcjonalności:
- Autoryzacja OAuth2 (Client ID + Secret)
- Wysyłanie dokumentu PDF do podpisu
- Pobieranie statusu dokumentu
- Pobieranie podpisanego dokumentu
- Obsługa webhooków

**Rozszerzenie istniejącego serwisu:**
```
app/Services/CertificateService.php
```
- Dodanie metody do wysyłania certyfikatu do Autenti
- Integracja z AutentiService

**Modyfikacje w bazie danych:**
```sql
ALTER TABLE certificates ADD COLUMN autenti_document_id VARCHAR(255);
ALTER TABLE certificates ADD COLUMN signature_status ENUM('pending', 'signed', 'rejected', 'none') DEFAULT 'none';
ALTER TABLE certificates ADD COLUMN signed_pdf_path VARCHAR(255);
```

**Nowy kontroler/trasy:**
```
app/Http/Controllers/AutentiWebhookController.php
routes/web.php - webhook endpoint
```

### 3. Workflow po integracji

#### Dla techników farmacji:
1. Użytkownik kończy kurs i zdaje test
2. System generuje PDF certyfikatu
3. **PDF wysyłany do Autenti API**
4. **Status: "oczekuje na podpis"**
5. **Webhook z Autenti informuje o podpisaniu**
6. **System pobiera podpisany PDF**
7. Użytkownik pobiera podpisany certyfikat

#### Dla farmaceutów:
1. Jak dotychczas - tylko generowanie PDF bez podpisu

### 4. Konfiguracja

**Zmienne środowiskowe (.env):**
```
AUTENTI_ENABLED=true
AUTENTI_CLIENT_ID=your_client_id
AUTENTI_CLIENT_SECRET=your_client_secret
AUTENTI_API_URL=https://api.autenti.com
AUTENTI_WEBHOOK_SECRET=your_webhook_secret
```

## Decyzje do podjęcia

1. **Kto podpisuje certyfikaty?**
   - Tylko technik_farmacji? ✓ (najprawdopodobniej)
   - Czy też farmaceuta?

2. **Kto będzie podpisywał dokumenty w Autenti?**
   - Dane osoby upoważnionej (email, dane)
   - Czy automatycznie czy ręcznie?

3. **Co jeśli podpisanie się nie powiedzie?**
   - Czy użytkownik dostaje niepodpisany certyfikat?
   - Czy czekamy aż zostanie podpisany?

4. **Webhooks:**
   - URL publiczny do odbierania powiadomień z Autenti
   - Konfiguracja bezpieczeństwa (weryfikacja HMAC)

## Referencje

- **WEBCON BPS integracja:** https://github.com/WEBCON-BPS/BPSExt-Signing-Autenti
- **Dokumentacja:** https://developers.autenti.com
- **Cennik API:** https://autenti.com/pl/cennik/api

## Status

🔄 **Plan do realizacji** - oczekiwanie na dane dostępowe i decyzje biznesowe

---

*Utworzone: 2025-11-04*
*Ostatnia aktualizacja: 2025-11-04*
