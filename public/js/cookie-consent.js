/**
 * Cookie Consent Manager - GDPR Compliant
 * LEK-AM Academy Platform
 */

class CookieConsentManager {
    constructor() {
        this.cookieName = 'lekam_cookie_consent';
        this.cookieExpiry = 365; // days
        this.consent = this.getStoredConsent();
        this.callbacks = {
            necessary: [],
            functional: [],
            analytics: [],
            marketing: []
        };

        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupEventListeners());
        } else {
            this.setupEventListeners();
        }

        // Show banner if no consent stored
        if (!this.consent) {
            this.showBanner();
        } else {
            // Apply stored consent
            this.applyConsent();
        }
    }

    setupEventListeners() {
        // Banner buttons
        const acceptAllBtn = document.getElementById('cookie-accept-all');
        const acceptNecessaryBtn = document.getElementById('cookie-accept-necessary');
        const settingsBtn = document.getElementById('cookie-settings');

        // Modal elements
        const modal = document.getElementById('cookie-modal');
        const modalClose = document.getElementById('cookie-modal-close');
        const savePreferencesBtn = document.getElementById('cookie-save-preferences');
        const acceptAllModalBtn = document.getElementById('cookie-accept-all-modal');
        const modalOverlay = modal?.querySelector('.cookie-modal-overlay');

        // Event listeners
        acceptAllBtn?.addEventListener('click', () => this.acceptAll());
        acceptNecessaryBtn?.addEventListener('click', () => this.acceptNecessaryOnly());
        settingsBtn?.addEventListener('click', () => this.showModal());

        modalClose?.addEventListener('click', () => this.hideModal());
        modalOverlay?.addEventListener('click', () => this.hideModal());
        savePreferencesBtn?.addEventListener('click', () => this.savePreferences());
        acceptAllModalBtn?.addEventListener('click', () => this.acceptAllFromModal());

        // ESC key to close modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal?.classList.contains('hidden')) {
                this.hideModal();
            }
        });
    }

    showBanner() {
        const banner = document.getElementById('cookie-banner');
        if (banner) {
            banner.classList.remove('hidden');
        }
    }

    hideBanner() {
        const banner = document.getElementById('cookie-banner');
        if (banner) {
            banner.classList.add('hidden');
        }
    }

    showModal() {
        const modal = document.getElementById('cookie-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Load current preferences
            this.loadCurrentPreferences();
        }
    }

    hideModal() {
        const modal = document.getElementById('cookie-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    loadCurrentPreferences() {
        const consent = this.consent || {
            necessary: true,
            functional: false,
            analytics: false,
            marketing: false
        };

        document.getElementById('cookies-necessary').checked = consent.necessary;
        document.getElementById('cookies-functional').checked = consent.functional;
        document.getElementById('cookies-analytics').checked = consent.analytics;
        document.getElementById('cookies-marketing').checked = consent.marketing;
    }

    acceptAll() {
        const consent = {
            necessary: true,
            functional: true,
            analytics: true,
            marketing: true,
            timestamp: Date.now(),
            version: '1.0'
        };

        this.saveConsent(consent);
        this.hideBanner();
        this.applyConsent();
        this.logConsentAction('accept_all');
    }

    acceptNecessaryOnly() {
        const consent = {
            necessary: true,
            functional: false,
            analytics: false,
            marketing: false,
            timestamp: Date.now(),
            version: '1.0'
        };

        this.saveConsent(consent);
        this.hideBanner();
        this.applyConsent();
        this.logConsentAction('accept_necessary_only');
    }

    savePreferences() {
        const consent = {
            necessary: true, // Always true
            functional: document.getElementById('cookies-functional').checked,
            analytics: document.getElementById('cookies-analytics').checked,
            marketing: document.getElementById('cookies-marketing').checked,
            timestamp: Date.now(),
            version: '1.0'
        };

        this.saveConsent(consent);
        this.hideModal();
        this.hideBanner();
        this.applyConsent();
        this.logConsentAction('save_preferences', consent);
    }

    acceptAllFromModal() {
        // Check all boxes
        document.getElementById('cookies-functional').checked = true;
        document.getElementById('cookies-analytics').checked = true;
        document.getElementById('cookies-marketing').checked = true;

        // Save preferences
        this.savePreferences();
    }

    saveConsent(consent) {
        this.consent = consent;
        const consentString = JSON.stringify(consent);

        // Save as cookie
        const expires = new Date();
        expires.setTime(expires.getTime() + (this.cookieExpiry * 24 * 60 * 60 * 1000));
        document.cookie = `${this.cookieName}=${consentString}; expires=${expires.toUTCString()}; path=/; SameSite=Strict`;

        // Also save to localStorage as backup
        try {
            localStorage.setItem(this.cookieName, consentString);
        } catch (e) {
            console.warn('Could not save to localStorage:', e);
        }
    }

    getStoredConsent() {
        // Try to get from cookie first
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === this.cookieName) {
                try {
                    return JSON.parse(decodeURIComponent(value));
                } catch (e) {
                    console.warn('Could not parse consent cookie:', e);
                }
            }
        }

        // Fallback to localStorage
        try {
            const stored = localStorage.getItem(this.cookieName);
            if (stored) {
                return JSON.parse(stored);
            }
        } catch (e) {
            console.warn('Could not parse consent from localStorage:', e);
        }

        return null;
    }

    applyConsent() {
        if (!this.consent) return;

        // Execute callbacks for each category
        Object.keys(this.callbacks).forEach(category => {
            if (this.consent[category]) {
                this.callbacks[category].forEach(callback => {
                    try {
                        callback();
                    } catch (e) {
                        console.error(`Error executing ${category} callback:`, e);
                    }
                });
            }
        });

        // Fire custom event
        const event = new CustomEvent('cookieConsentApplied', {
            detail: { consent: this.consent }
        });
        document.dispatchEvent(event);

        // Fire callback hooks for external analytics integration
        if (typeof window.cookieConsentCallbacks !== 'undefined') {
            window.cookieConsentCallbacks.forEach(callback => {
                if (typeof callback === 'function') {
                    try {
                        callback(this.consent);
                    } catch (e) {
                        console.error('Error executing cookie consent callback:', e);
                    }
                }
            });
        }
    }

    logConsentAction(action, data = null) {
        // Log consent action for auditing purposes
        const logData = {
            action: action,
            timestamp: new Date().toISOString(),
            url: window.location.href,
            userAgent: navigator.userAgent,
            data: data
        };

        // Send to analytics if analytics cookies are accepted
        if (this.consent && this.consent.analytics) {
            // This is where you'd send to your analytics service
            console.log('Cookie consent action:', logData);

            // Example: Send to Google Analytics
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cookie_consent', {
                    event_category: 'GDPR',
                    event_label: action,
                    custom_parameter: data
                });
            }
        }
    }

    // Public API methods
    hasConsent(category = null) {
        if (!this.consent) return false;
        if (!category) return true; // Has any consent
        return this.consent[category] === true;
    }

    revokeConsent() {
        // Clear stored consent
        document.cookie = `${this.cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
        try {
            localStorage.removeItem(this.cookieName);
        } catch (e) {
            console.warn('Could not remove from localStorage:', e);
        }

        this.consent = null;
        this.showBanner();

        // Fire revoke event
        const event = new CustomEvent('cookieConsentRevoked');
        document.dispatchEvent(event);

        this.logConsentAction('revoke_consent');
    }

    updatePreferences() {
        this.showModal();
    }

    getConsent() {
        return this.consent;
    }

    // Method to register callbacks for when specific cookie categories are accepted
    onConsent(category, callback) {
        if (this.callbacks[category]) {
            this.callbacks[category].push(callback);

            // If consent already exists and this category is accepted, execute immediately
            if (this.consent && this.consent[category]) {
                try {
                    callback();
                } catch (e) {
                    console.error(`Error executing ${category} callback:`, e);
                }
            }
        }
    }

    // Utility methods for external scripts
    isAnalyticsAllowed() {
        return this.hasConsent('analytics');
    }

    isMarketingAllowed() {
        return this.hasConsent('marketing');
    }

    isFunctionalAllowed() {
        return this.hasConsent('functional');
    }
}

// Global instance
window.CookieConsent = new CookieConsentManager();

// Helper functions for easy integration
window.onCookieConsent = function(category, callback) {
    window.CookieConsent.onConsent(category, callback);
};

window.hasAnalyticsConsent = function() {
    return window.CookieConsent.isAnalyticsAllowed();
};

window.hasMarketingConsent = function() {
    return window.CookieConsent.isMarketingAllowed();
};

window.hasFunctionalConsent = function() {
    return window.CookieConsent.isFunctionalAllowed();
};

// Global function for opening cookie modal (used in footer links)
window.openCookieModal = function() {
    if (window.CookieConsent) {
        window.CookieConsent.showModal();
    }
};

// Example usage for future analytics integration:
//
// Google Analytics 4 Integration:
// window.onCookieConsent('analytics', function() {
//     gtag('config', 'GA_MEASUREMENT_ID');
// });
//
// Facebook Pixel Integration:
// window.onCookieConsent('marketing', function() {
//     fbq('init', 'PIXEL_ID');
//     fbq('track', 'PageView');
// });
//
// Hotjar Integration:
// window.onCookieConsent('analytics', function() {
//     (function(h,o,t,j,a,r){
//         h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
//         h._hjSettings={hjid: HOTJAR_ID, hjsv: 6};
//         // ... rest of Hotjar code
//     })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
// });