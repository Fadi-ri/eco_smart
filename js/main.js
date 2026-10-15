
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

    const icons = document.querySelectorAll('.js-theme-toggle i');
    icons.forEach(icon => {
        if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill text-warning';
        } else {
            icon.className = 'bi bi-moon-stars-fill';
        }
    });
}
