/**
 * Scripts generaux - EcoSmart Lab
 * ECAM-EPMI 1AE - Projet Web
 */

const THEME_STORAGE_KEY = 'ecosmart-theme';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialisation du Theme (Clair / Sombre)
    initThemeManager();

    // 2. Initialisation des composants Bootstrap (Tooltips, Popovers)
    initBootstrapComponents();

    // 3. Gestion des boutons interactifs & animations
    initInteractiveUI();
});


function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.body.setAttribute('data-theme', theme);

    // Bootstrap 5.3 gere ses propres composants (modals, dropdowns, badges) via data-bs-theme
    document.documentElement.setAttribute('data-bs-theme', theme);

    const icons = document.querySelectorAll('.js-theme-toggle i');
    icons.forEach(icon => {
        if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill text-warning';
        } else {
            icon.className = 'bi bi-moon-stars-fill';
        }
    });

    document.querySelectorAll('.js-theme-toggle').forEach(btn => {
        btn.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        btn.setAttribute('title', theme === 'dark' ? 'Passer en theme clair' : 'Passer en theme sombre');
    });
}

/**
 * Retourne le theme a utiliser : choix memorise, sinon preference du systeme.
 */
function getPreferredTheme() {
    let stored = null;
    try {
        stored = localStorage.getItem(THEME_STORAGE_KEY);
    } catch (e) {
        // localStorage indisponible (navigation privee) : on ignore
    }

    if (stored === 'dark' || stored === 'light') {
        return stored;
    }

    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light';
}

function storeTheme(theme) {
    try {
        localStorage.setItem(THEME_STORAGE_KEY, theme);
    } catch (e) {
        // Echec silencieux : le theme reste actif pour la page courante
    }
}

function initThemeManager() {
    applyTheme(getPreferredTheme());

    // Bascule au clic (le bouton existe en version desktop et mobile)
    document.querySelectorAll('.js-theme-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            storeTheme(next);
        });
    });

    // Suivi de la preference systeme tant que l utilisateur n a rien choisi
    if (window.matchMedia) {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        const onSystemChange = (event) => {
            let stored = null;
            try {
                stored = localStorage.getItem(THEME_STORAGE_KEY);
            } catch (e) {}

            if (stored !== 'dark' && stored !== 'light') {
                applyTheme(event.matches ? 'dark' : 'light');
            }
        };

        if (typeof mediaQuery.addEventListener === 'function') {
            mediaQuery.addEventListener('change', onSystemChange);
        } else if (typeof mediaQuery.addListener === 'function') {
            mediaQuery.addListener(onSystemChange);
        }
    }
}

function initBootstrapComponents() {
    if (typeof bootstrap === 'undefined') return;

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => new bootstrap.Popover(el));

    // Enchainement modal de choix -> modal de formulaire (projets.php)
    document.querySelectorAll('.js-open-sub-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.target);
            if (target) new bootstrap.Modal(target).show();
        });
    });
}

function initInteractiveUI() {
    // Defilement doux pour les ancres internes
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(link => {
        link.addEventListener('click', (event) => {
            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Compteurs animes (section statistiques de l accueil)
    document.querySelectorAll('.js-counter').forEach(el => animateCounter(el));

    // Bouton "retour en haut"
    const backToTop = document.querySelector('.js-back-to-top');
    if (backToTop) {
        const toggleBackToTop = () => backToTop.classList.toggle('d-none', window.scrollY <= 400);
        window.addEventListener('scroll', toggleBackToTop, { passive: true });
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        toggleBackToTop();
    }

    // Fermeture automatique des messages flash apres 6 secondes
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined') {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            }
        }, 6000);
    });
}

function animateCounter(el) {
    const target = parseFloat(el.dataset.target || el.textContent) || 0;
    const suffix = el.dataset.suffix || '';

    // La valeur finale est deja dans le HTML : on ne l anime pas si
    // l utilisateur a demande a reduire les animations.
    const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) {
        el.textContent = Math.round(target).toLocaleString('fr-FR') + suffix;
        return;
    }

    const duration = 1200;
    const start = performance.now();

    const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        // Easing "ease-out" pour un arret en douceur
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.round(target * eased);
        el.textContent = value.toLocaleString('fr-FR') + suffix;
        if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
}
