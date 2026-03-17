# Analiza problemu: Postęp lekcji nie zapisuje się (Anna Adamska – adamska79@vp.pl)

## Opis problemu od Klientki

1. **Lekcja 1** – obejrzana w całości, zaliczona ✓
2. **Lekcja 2** – rozpoczęta wczoraj, zatrzymana w trakcie, dokończona dziś do końca
3. **Efekty:**
   - Lekcja 2 **nie została zaliczona** mimo obejrzenia do końca
   - Zielony pasek postępu **nie pokazuje się**
   - **Nie można przesunąć** paska postępu
   - Lekcja **zaczyna się od nowa** (brak zapisanego punktu wznowienia)

## Diagnoza techniczna

### Jak działa zapis postępu wideo

1. **Zapis pozycji** (`video_position` w tabeli `user_progress`):
   - Co 5 sekund podczas odtwarzania
   - Przy pauzie
   - Przy zakończeniu wideo
   - Przy zamykaniu strony (`beforeunload`)

2. **Zaliczanie lekcji** – automatycznie gdy:
   - Wideo dojdzie do końca (event `ended`)
   - Obejrzano ≥80% materiału
   - Obejrzano minimum 5 sekund

### Prawdopodobne przyczyny

| Problem | Przyczyna |
|---------|-----------|
| **Postęp nie zapisuje się** | `beforeunload` + `fetch()` są zawodne – przeglądarka często przerywa request przed wysłaniem |
| **Brak zielonego paska** | Brak `video_position` w bazie → pasek startuje od 0%, nie ma danych do wyświetlenia |
| **Lekcja nie zaliczona** | Możliwy błąd CSRF (419) po długiej sesji lub problem z wywołaniem `completeLesson` po przerwie |
| **Nie można przesunąć paska** | Pasek jest klikalny – jeśli brak zapisanego postępu, użytkownik może kliknąć w dowolne miejsce, aby „odświeżyć” pozycję |

### Co sprawdzić po SSH

```bash
# 1. Użytkownik Anna Adamska
php artisan tinker
>>> $user = \App\Models\User::where('email', 'adamska79@vp.pl')->first();
>>> $user->id;

# 2. Postęp dla lekcji 2 (podstaw course_id i lesson_id)
>>> \App\Models\UserProgress::where('user_id', $user->id)
    ->where('lesson_id', 2)  # lub właściwy ID lekcji 2
    ->get();

# 3. Logi zapisu pozycji
tail -f storage/logs/laravel.log
# Szukaj: "saveVideoPosition" lub "DEBUG"

# 4. Sprawdzenie struktury user_progress
>>> \DB::table('user_progress')->where('user_id', $user->id)->get();
```

### Oczekiwane wyniki

- Dla lekcji 2 powinien być rekord z `video_position` > 0 (jeśli zapis działał)
- Jeśli `video_position` = NULL lub brak rekordu → zapis nie działał

### Rozwiązanie tymczasowe (obecna instrukcja supportu)

„Kliknij w zielony pasek postępu mniej więcej w miejscu, w którym przerwała Pani lekcję” – to wymusza `seek` i aktualizację `video_position`.

---

## Wdrożone poprawki

1. **`navigator.sendBeacon()`** – niezawodniejszy zapis przy zamykaniu strony (fetch bywa przerywany)
2. **`visibilitychange`** – zapis przy przełączeniu zakładki (np. użytkownik zatrzymuje i wraca później)
3. **`pagehide`** – fallback dla Safari iOS i innych mobile
4. **Częstszy zapis** – co 3 sekundy zamiast 5 podczas odtwarzania

Backend akceptuje zarówno JSON (fetch) jak i FormData (sendBeacon) – pole `position` + `_token` dla CSRF.
