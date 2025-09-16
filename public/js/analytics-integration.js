// Analytics Integration Example for Cookie Consent System
// This file shows how to integrate popular analytics tools with the cookie consent system

// Initialize callback array if it doesn't exist
if (typeof window.cookieConsentCallbacks === 'undefined') {
    window.cookieConsentCallbacks = [];
}

// Add callback for analytics integration
window.cookieConsentCallbacks.push(function(consent) {
    console.log('Cookie consent received:', consent);

    // Google Analytics 4 (gtag) integration
    if (consent.analytics && typeof gtag !== 'undefined') {
        console.log('✓ Initializing Google Analytics');
        gtag('consent', 'update', {
            'analytics_storage': 'granted',
            'ad_storage': consent.marketing ? 'granted' : 'denied'
        });

        // Optional: Configure additional GA4 settings
        // gtag('config', 'GA_MEASUREMENT_ID', {
        //     'anonymize_ip': true,
        //     'allow_google_signals': consent.marketing
        // });
    } else if (!consent.analytics && typeof gtag !== 'undefined') {
        console.log('✗ Denying Google Analytics');
        gtag('consent', 'update', {
            'analytics_storage': 'denied',
            'ad_storage': 'denied'
        });
    }

    // Facebook Pixel integration
    if (consent.marketing && typeof fbq !== 'undefined') {
        console.log('✓ Initializing Facebook Pixel');
        fbq('consent', 'grant');
        // Optional: Track page view
        // fbq('track', 'PageView');
    } else if (!consent.marketing && typeof fbq !== 'undefined') {
        console.log('✗ Denying Facebook Pixel');
        fbq('consent', 'revoke');
    }

    // LinkedIn Insight Tag integration
    if (consent.marketing && typeof _linkedin_partner_id !== 'undefined') {
        console.log('✓ Initializing LinkedIn Insight Tag');
        // LinkedIn tracking code would go here
    }

    // Hotjar integration
    if (consent.analytics && typeof hj !== 'undefined') {
        console.log('✓ Initializing Hotjar');
        // Hotjar tracking would be enabled here
    }

    // Custom analytics integration
    if (consent.analytics) {
        console.log('✓ Custom analytics enabled');
        // Add your custom analytics initialization here
        // Example: initializeCustomAnalytics();
    }

    // Marketing tools integration
    if (consent.marketing) {
        console.log('✓ Marketing tools enabled');
        // Add your marketing tools initialization here
        // Example: initializeMarketingTools();
    }
});

// Example function to check current consent state
function getCurrentConsentState() {
    try {
        const stored = localStorage.getItem('cookie_consent');
        if (stored) {
            return JSON.parse(stored);
        }
    } catch (e) {
        console.warn('Could not parse consent from localStorage:', e);
    }
    return null;
}

// Example function to conditionally load analytics scripts
function loadAnalyticsScripts() {
    const consent = getCurrentConsentState();
    if (!consent) return;

    // Load Google Analytics if consent given
    if (consent.analytics && !document.querySelector('script[src*="googletagmanager.com"]')) {
        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=YOUR_GA_ID';
        document.head.appendChild(script);

        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'YOUR_GA_ID', {
            'anonymize_ip': true
        });
    }

    // Load Facebook Pixel if marketing consent given
    if (consent.marketing && !document.querySelector('script[src*="connect.facebook.net"]')) {
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', 'YOUR_PIXEL_ID');
        fbq('track', 'PageView');
    }
}

// Listen for consent changes
document.addEventListener('cookieConsentApplied', function(event) {
    console.log('Cookie consent applied:', event.detail.consent);
    loadAnalyticsScripts();
});

// Initialize on page load if consent already exists
document.addEventListener('DOMContentLoaded', function() {
    loadAnalyticsScripts();
});