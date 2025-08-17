# System Przycisków LEKAM

## Przegląd

Nowy system przycisków został zaprojektowany z myślą o spójności i łatwości utrzymania. Wszystkie przyciski używają koloru głównego `#21235F` i zaokrąglenia `16px`.

## Klasy Podstawowe

### `.btn`
Podstawowa klasa dla wszystkich przycisków:
- `border-radius: 16px`
- `padding: 0.5rem 1rem`
- `font-weight: 500`
- `transition: all 0.2s ease-in-out`

## Typy Przycisków

### 1. Przyciski Pełne (Primary)
```html
<button class="btn btn-primary">Przycisk Pełny</button>
```
- Tło: `#21235F`
- Tekst: `white`
- Obramowanie: `2px solid #21235F`

### 2. Przyciski Obramowane (Secondary/Outlined)
```html
<button class="btn btn-secondary">Przycisk Obramowany</button>
<button class="btn btn-outlined">Przycisk Outlined</button>
```
- Tło: `transparent`
- Tekst: `#21235F`
- Obramowanie: `2px solid #21235F`

### 3. Przyciski Funkcjonalne
```html
<button class="btn btn-success">Sukces</button>
<button class="btn btn-danger">Niebezpieczeństwo</button>
<button class="btn btn-warning">Ostrzeżenie</button>
<button class="btn btn-info">Informacja</button>
```

## Efekty Hover

Wszystkie przyciski mają spójne efekty hover:
- `transform: translateY(-1px)` - lekki ruch w górę
- `box-shadow` - cień z kolorem przycisku
- Ciemniejszy odcień koloru tła

## Responsywność

Na urządzeniach mobilnych:
- Większy padding: `0.75rem 1rem`
- Większa czcionka: `1rem`

## Dostępność

- Focus outline: `2px solid #21235F`
- Disabled state: `opacity: 0.5`
- Keyboard navigation support

## Przykłady Użycia

### Formularze
```html
<button type="submit" class="btn btn-primary">Zapisz</button>
<button type="button" class="btn btn-secondary">Anuluj</button>
```

### Nawigacja
```html
<a href="/dashboard" class="btn btn-primary">Moje konto</a>
<a href="/logout" class="btn btn-outlined">Wyloguj</a>
```

### Akcje
```html
<button class="btn btn-success">Ukończ lekcję</button>
<button class="btn btn-danger">Usuń</button>
<button class="btn btn-info">Edytuj</button>
```

## Kolory

### Główny kolor: #21235F
- Używany w przyciskach primary i secondary
- Spójny z resztą aplikacji

### Kolory funkcjonalne:
- **Success**: #10B981 (zielony)
- **Danger**: #EF4444 (czerwony)
- **Warning**: #F59E0B (żółty)
- **Info**: #06B6D4 (niebieski)

## Integracja z Tailwind CSS

System jest zintegrowany z Tailwind CSS poprzez konfigurację w `tailwind.config.js`:
- Kolory primary w palecie Tailwind
- Niestandardowe zaokrąglenia
- Responsywne breakpointy 