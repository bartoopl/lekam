# Naprawa zablokowanej próby testu i wystawienie certyfikatu

## Kontekst

Użytkownik może mieć ukończony kurs, ale w tabeli `quiz_attempts` próba ma `completed_at = NULL` (np. błąd sieci, wygasła sesja, wcześniejszy problem z zapisem wyniku). Wtedy nie powstanie certyfikat.

W kodzie aplikacji (od commita z poprawką quizu) zapis wyniku jest transakcyjny, a zakończenie testu wysyłane jest przez `fetch` z czytelnym komunikatem błędu — to ogranicza takie przypadki.

## Komenda administracyjna (produkcja / VPS)

Na serwerze, w katalogu aplikacji:

```bash
cd /var/www/lekam
php artisan quiz:repair-pass PRÓBA_ID [KOLEJNE_ID ...]
```

- Uzupełnia odpowiedzi tak, aby próba **zaliczyła** test (100% zgodnie z pytaniami w próbie).
- Ustawia `completed_at`, przelicza wynik.
- Dla **technika farmacji** (`user_type = technik_farmacji`): wywołuje wystawienie certyfikatu i proces wysyłki do podpisu (jak po normalnym zaliczeniu), o ile nie ma już certyfikatu na ten kurs.

Opcja `--no-mail`: tylko zapis wyniku w bazie, **bez** certyfikatu i maila do podpisu (np. testy).

Przykład:

```bash
php artisan quiz:repair-pass 148
```

## Jak znaleźć `PRÓBA_ID`

W MySQL:

```sql
SELECT qa.id, u.email, qa.started_at, qa.completed_at, q.id AS quiz_id
FROM quiz_attempts qa
JOIN users u ON u.id = qa.user_id
JOIN quizzes q ON q.id = qa.quiz_id
WHERE u.email = 'adres@klienta.pl'
ORDER BY qa.id DESC;
```

Wybierz próbę z `completed_at IS NULL` (najczęściej ostatnią).

## Uwagi

- To narzędzie **wyłącznie administracyjne** — używać świadomie (np. po weryfikacji zgłoszenia).
- Jeśli użytkownik ma kilka niedokończonych prób, zwykle wystarczy naprawić **jedną** (najnowszą); certyfikat jest jeden na parę (użytkownik, kurs).
