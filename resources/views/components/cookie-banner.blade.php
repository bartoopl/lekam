<!-- Cookie Consent Banner -->
<div id="cookie-banner" class="cookie-banner hidden">
    <div class="cookie-banner-content">
        <div class="cookie-banner-text">
            <h3>Używamy plików cookies</h3>
            <p>Ta strona używa plików cookies, aby zapewnić najlepsze doświadczenia. Możesz wybrać, które kategorie cookies chcesz zaakceptować.</p>
        </div>
        <div class="cookie-banner-buttons">
            <button id="cookie-settings" class="btn-cookie-settings">Ustawienia</button>
            <button id="cookie-accept-necessary" class="btn-cookie-secondary">Tylko niezbędne</button>
            <button id="cookie-accept-all" class="btn-cookie-primary">Akceptuj wszystkie</button>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-modal" class="cookie-modal hidden">
    <div class="cookie-modal-overlay"></div>
    <div class="cookie-modal-content">
        <div class="cookie-modal-header">
            <h3>Ustawienia plików cookies</h3>
            <button id="cookie-modal-close" class="cookie-modal-close">&times;</button>
        </div>

        <div class="cookie-modal-body">
            <p>Dostosuj swoje preferencje dotyczące plików cookies. Możesz włączyć lub wyłączyć różne typy cookies poniżej.</p>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-category-label">
                        <input type="checkbox" id="cookies-necessary" checked disabled>
                        <span class="cookie-category-title">Niezbędne cookies</span>
                        <span class="cookie-category-required">(Wymagane)</span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Te pliki cookies są niezbędne do funkcjonowania strony i nie mogą być wyłączone. Obejmują pliki cookies sesji, uwierzytelniania i bezpieczeństwa.
                </p>
            </div>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-category-label">
                        <input type="checkbox" id="cookies-functional">
                        <span class="cookie-category-title">Funkcjonalne cookies</span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Te pliki cookies umożliwiają zapamiętywanie wyborów użytkownika (np. język, region) i dostarczają ulepszone, bardziej spersonalizowane funkcje.
                </p>
            </div>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-category-label">
                        <input type="checkbox" id="cookies-analytics">
                        <span class="cookie-category-title">Analityczne cookies</span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Te pliki cookies pomagają nam zrozumieć, jak odwiedzający korzystają ze strony, zbierając i raportując informacje anonimowo (Google Analytics, itp.).
                </p>
            </div>

            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-category-label">
                        <input type="checkbox" id="cookies-marketing">
                        <span class="cookie-category-title">Marketingowe cookies</span>
                    </label>
                </div>
                <p class="cookie-category-description">
                    Te pliki cookies są używane do śledzenia odwiedzających na stronach internetowych. Służą do wyświetlania reklam, które są istotne i angażujące dla poszczególnych użytkowników.
                </p>
            </div>
        </div>

        <div class="cookie-modal-footer">
            <button id="cookie-save-preferences" class="btn-cookie-primary">Zapisz preferencje</button>
            <button id="cookie-accept-all-modal" class="btn-cookie-secondary">Akceptuj wszystkie</button>
            <a href="{{ route('cookies') }}" class="cookie-policy-link" target="_blank">Polityka cookies</a>
        </div>
    </div>
</div>

<style>
/* Cookie Banner Styles */
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-top: 1px solid #e5e7eb;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    padding: 1.5rem;
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
    }
    to {
        transform: translateY(0);
    }
}

.cookie-banner-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.cookie-banner-text h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    color: #21235F;
    margin-bottom: 0.5rem;
}

.cookie-banner-text p {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.4;
}

.cookie-banner-buttons {
    display: flex;
    gap: 0.75rem;
    flex-shrink: 0;
}

.btn-cookie-primary,
.btn-cookie-secondary,
.btn-cookie-settings {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-cookie-primary {
    background: #21235F;
    color: white;
}

.btn-cookie-primary:hover {
    background: #1a1a4d;
    transform: translateY(-1px);
}

.btn-cookie-secondary {
    background: transparent;
    color: #21235F;
    border: 1px solid #21235F;
}

.btn-cookie-secondary:hover {
    background: #21235F;
    color: white;
}

.btn-cookie-settings {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-cookie-settings:hover {
    background: #e5e7eb;
}

/* Cookie Modal Styles */
.cookie-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.cookie-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.cookie-modal-content {
    position: relative;
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    animation: modalAppear 0.3s ease-out;
}

@keyframes modalAppear {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.cookie-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.cookie-modal-header h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.25rem;
    color: #21235F;
    margin: 0;
}

.cookie-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #9ca3af;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.cookie-modal-close:hover {
    background: #f3f4f6;
    color: #374151;
}

.cookie-modal-body {
    padding: 1.5rem;
}

.cookie-modal-body > p {
    font-family: 'Poppins', sans-serif;
    color: #6b7280;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.cookie-category {
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
}

.cookie-category-header {
    margin-bottom: 0.5rem;
}

.cookie-category-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}

.cookie-category-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #21235F;
}

.cookie-category-title {
    font-weight: 600;
    color: #21235F;
    font-size: 1rem;
}

.cookie-category-required {
    font-size: 0.8rem;
    color: #9ca3af;
    font-weight: 400;
}

.cookie-category-description {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #6b7280;
    line-height: 1.4;
    margin: 0;
    margin-left: 2.5rem;
}

.cookie-modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 1rem;
    align-items: center;
}

.cookie-policy-link {
    color: #21235F;
    text-decoration: underline;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    margin-left: auto;
}

.cookie-policy-link:hover {
    color: #1a1a4d;
}

/* Hidden state */
.hidden {
    display: none !important;
}

/* Responsive */
@media (max-width: 768px) {
    .cookie-banner-content {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .cookie-banner-buttons {
        flex-direction: column;
    }

    .cookie-modal-content {
        margin: 1rem;
        max-height: calc(100vh - 2rem);
    }

    .cookie-modal-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .cookie-policy-link {
        margin-left: 0;
        text-align: center;
    }

    .cookie-category-description {
        margin-left: 0;
        margin-top: 0.5rem;
    }
}
</style>