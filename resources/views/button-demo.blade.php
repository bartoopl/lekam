<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demonstracja Systemu Przycisków LEKAM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white-override rounded-xl p-8 shadow-lg">
            <h1 class="text-3xl font-bold text-primary-500 mb-8">System Przycisków LEKAM</h1>
            
            <!-- Podstawowe przyciski -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Podstawowe Przyciski</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="btn btn-primary">Przycisk Pełny</button>
                    <button class="btn btn-secondary">Przycisk Obramowany</button>
                    <button class="btn btn-outlined">Przycisk Outlined</button>
                </div>
            </section>

            <!-- Przyciski funkcjonalne -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Przyciski Funkcjonalne</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="btn btn-success">Sukces</button>
                    <button class="btn btn-danger">Niebezpieczeństwo</button>
                    <button class="btn btn-warning">Ostrzeżenie</button>
                    <button class="btn btn-info">Informacja</button>
                </div>
            </section>

            <!-- Przyciski nawigacji -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Przyciski Nawigacji</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="account-button">Konto</button>
                    <button class="login-button">Zaloguj</button>
                    <button class="register-button">Zarejestruj</button>
                    <button class="logout-button">Wyloguj</button>
                    <button class="admin-button">Admin</button>
                </div>
            </section>

            <!-- Przyciski panelu admina -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Przyciski Panelu Admina</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="admin-quick-action">Szybka Akcja</button>
                    <button class="table-button view">Zobacz</button>
                    <button class="table-button edit">Edytuj</button>
                    <button class="table-button delete">Usuń</button>
                    <button class="form-button primary">Zapisz</button>
                    <button class="form-button secondary">Anuluj</button>
                </div>
            </section>

            <!-- Przyciski kursów i lekcji -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Przyciski Kursów i Lekcji</h2>
                <div class="flex flex-wrap gap-4">
                    <button class="course-button">Rozpocznij Kurs</button>
                    <button class="course-button secondary">Szczegóły Kursu</button>
                    <button class="lesson-button">Rozpocznij Lekcję</button>
                    <button class="lesson-button secondary">Szczegóły Lekcji</button>
                </div>
            </section>

            <!-- Przyciski materiałów -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Przyciski Materiałów</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="material-download">📄 Pobierz PDF</a>
                    <a href="#" class="material-download">📊 Pobierz Excel</a>
                    <a href="#" class="material-download">🎥 Pobierz Video</a>
                </div>
            </section>

            <!-- Formularz demonstracyjny -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Formularz Demonstracyjny</h2>
                <form class="space-y-4 max-w-md">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nazwa</label>
                        <input type="text" class="form-input w-full" placeholder="Wprowadź nazwę">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" class="form-input w-full" placeholder="Wprowadź email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opis</label>
                        <textarea class="form-input w-full" rows="3" placeholder="Wprowadź opis"></textarea>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                        <button type="button" class="btn btn-secondary">Anuluj</button>
                    </div>
                </form>
            </section>

            <!-- Kolory Tailwind -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Kolory Tailwind CSS</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-primary-500 text-white p-4 rounded-xl text-center">
                        <div class="font-bold">Primary 500</div>
                        <div class="text-sm">#292870</div>
                    </div>
                    <div class="bg-primary-600 text-white p-4 rounded-xl text-center">
                        <div class="font-bold">Primary 600</div>
                        <div class="text-sm">#1f1f5a</div>
                    </div>
                    <div class="bg-lekam-primary text-white p-4 rounded-xl text-center">
                        <div class="font-bold">Lekam Primary</div>
                        <div class="text-sm">#292870</div>
                    </div>
                    <div class="bg-lekam-accent text-white p-4 rounded-xl text-center">
                        <div class="font-bold">Lekam Accent</div>
                        <div class="text-sm">#3B82F6</div>
                    </div>
                </div>
            </section>

            <!-- Informacje techniczne -->
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Informacje Techniczne</h2>
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Specyfikacje:</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li>• <strong>Kolor główny:</strong> #292870</li>
                        <li>• <strong>Zaokrąglenie:</strong> 16px</li>
                        <li>• <strong>Padding:</strong> 0.5rem 1rem</li>
                        <li>• <strong>Transition:</strong> all 0.2s ease-in-out</li>
                        <li>• <strong>Hover effect:</strong> translateY(-1px) + box-shadow</li>
                        <li>• <strong>Responsywność:</strong> Automatyczna</li>
                        <li>• <strong>Dostępność:</strong> WCAG 2.1 AA</li>
                    </ul>
                </div>
            </section>

            <!-- Link powrotu -->
            <div class="text-center">
                <a href="/" class="btn btn-outlined">← Powrót do strony głównej</a>
            </div>
        </div>
    </div>
</body>
</html> 