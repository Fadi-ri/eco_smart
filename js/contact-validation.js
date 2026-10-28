/**
 * Validation live du formulaire de contact
 * EcoSmart Lab - ECAM-EPMI 1AE
 *
 * Ces controles sont un confort pour lutilisateur : la validation qui fait foi
 * reste celle de actions/contact.php cote serveur.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const message = document.getElementById('message');
    const counter = document.getElementById('messageCounter');
    const maxLength = parseInt(message?.getAttribute('maxlength') || '2000', 10);

    function updateCounter() {
        if (!message || !counter) return;
        const length = message.value.length;
        counter.textContent = length;
        counter.classList.toggle('text-danger', length > maxLength - 100);
    }

    function validateField(field) {
        if (!field.willValidate) return true;
        const valid = field.checkValidity();
        field.classList.toggle('is-valid', valid && field.value.trim() !== '');
        field.classList.toggle('is-invalid', !valid);
        return valid;
    }

    // Validation au fil de la saisie, une fois le champ quitte une premiere fois
    form.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('input', () => {
            if (field.classList.contains('is-invalid') || field.classList.contains('is-valid')) {
                validateField(field);
            }
        });
    });

    message?.addEventListener('input', updateCounter);
    updateCounter();

    form.addEventListener('submit', (event) => {
        let firstInvalid = null;

        form.querySelectorAll('input, select, textarea').forEach(field => {
            if (!validateField(field) && !firstInvalid) {
                firstInvalid = field;
            }
        });

        if (firstInvalid) {
            event.preventDefault();
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Remise a zero complete : on enleve aussi les marqueurs de validation
    form.addEventListener('reset', () => {
        form.querySelectorAll('.is-valid, .is-invalid').forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
        setTimeout(updateCounter, 0);
    });
});
