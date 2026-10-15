document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('projectForm');
    if (!form) return;

    const progressBar = document.getElementById('formProgressBar');
    const domainesError = document.getElementById('domainesError');
    const domainesCheckboxes = form.querySelectorAll('input[name="domaines_cles[]"]');

    function bindCardToggle(cardSelector) {
        document.querySelectorAll(cardSelector).forEach(card => {
            const input = card.querySelector('input');
            if (!input) return;
            input.addEventListener('change', () => {
                if (input.type === 'radio') {
                    document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                        radio.closest(cardSelector)?.classList.toggle('active', radio.checked);
                    });
                } else {
                    card.classList.toggle('active', input.checked);
                }
            });
        });
    }

    bindCardToggle('.custom-radio-card');
    bindCardToggle('.custom-check-card');

    function countCheckedDomaines() {
        return Array.from(domainesCheckboxes).filter(cb => cb.checked).length;
    }

    function setText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }

    function updateProgress() {
        const groups = ['nom', 'prenom', 'email', 'telephone', 'niveau_etudes', 'filiere', 'titre_projet', 'type_projet', 'date_debut', 'duree_semaines', 'besoin_laboratoire', 'description'];
        let filled = 0;

        groups.forEach(name => {
            const field = form.elements[name];
            if (!field) return;
            if (field instanceof RadioNodeList) {
                if (Array.from(field).some(input => input.checked)) filled++;
            } else if (field.type === 'radio' || field.type === 'checkbox') {
                if (field.checked) filled++;
            } else if (field.value.trim() !== '') {
                filled++;
            }
        });

        if (countCheckedDomaines() > 0) filled++;

        const percent = Math.min(100, Math.round((filled / (groups.length + 1)) * 100));
        if (progressBar) {
            progressBar.style.width = percent + '%';
            progressBar.setAttribute('aria-valuenow', percent);
            progressBar.textContent = percent + '%';
        }
    }

    function updateSummary() {
        const val = (name) => form.elements[name]?.value ?? '';

        setText('sum_nom', `${val('prenom')} ${val('nom')}`.trim() || 'Non renseigne');
        setText('sum_email', val('email') || 'Non renseigne');

        const niveau = form.querySelector('input[name="niveau_etudes"]:checked');
        setText('sum_niveau', niveau ? niveau.value : 'Non renseigne');

        setText('sum_filiere', val('filiere') || 'Non selectionnee');
        setText('sum_titre', val('titre_projet') || 'Projet sans titre');

        const type = form.querySelector('input[name="type_projet"]:checked');
        setText('sum_type', type ? type.value : 'Non renseigne');

        const budget = parseFloat(val('budget_estime')) || 0;
        setText('sum_budget', budget.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €');

        const date = val('date_debut');
        const duree = val('duree_semaines');
        setText('sum_date', date ? `${date} (${duree} semaines)` : 'A definir');

        const labo = form.querySelector('input[name="besoin_laboratoire"]:checked');
        setText('sum_labo', labo ? labo.value : 'Non renseigne');

        const domainesContainer = document.getElementById('sum_domaines');
        if (domainesContainer) {
            const checked = Array.from(domainesCheckboxes).filter(cb => cb.checked);
            domainesContainer.innerHTML = '';
            if (checked.length === 0) {
                domainesContainer.textContent = 'Aucun domaine selectionne';
            } else {
                checked.forEach(cb => {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-secondary-subtle text-secondary me-1';
                    badge.textContent = cb.value;
                    domainesContainer.appendChild(badge);
                });
            }
        }
    }

    form.addEventListener('input', () => { updateSummary(); updateProgress(); });
    form.addEventListener('change', () => { updateSummary(); updateProgress(); });

    form.addEventListener('submit', (event) => {
        const hasDomaine = countCheckedDomaines() > 0;
        domainesError?.classList.toggle('d-none', hasDomaine);

        if (!form.checkValidity() || !hasDomaine) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    const summaryModalEl = document.getElementById('summaryModal');
    const summaryModal = summaryModalEl ? new bootstrap.Modal(summaryModalEl) : null;
    const summaryModalContent = document.getElementById('summaryModalContent');

    document.getElementById('btnOpenSummaryModal')?.addEventListener('click', () => {
        updateSummary();
        if (summaryModalContent) {
            const domaines = Array.from(domainesCheckboxes).filter(cb => cb.checked).map(cb => cb.value).join(', ') || 'Aucun';
            const rows = [
                ['Porteur', document.getElementById('sum_nom').textContent],
                ['Email', document.getElementById('sum_email').textContent],
                ['Promotion', document.getElementById('sum_niveau').textContent],
                ['Filiere', document.getElementById('sum_filiere').textContent],
                ['Projet', document.getElementById('sum_titre').textContent],
                ['Type', document.getElementById('sum_type').textContent],
                ['Budget', document.getElementById('sum_budget').textContent],
                ['Planning', document.getElementById('sum_date').textContent],
                ['Acces Labo', document.getElementById('sum_labo').textContent],
                ['Domaines', domaines],
            ];
            summaryModalContent.innerHTML = '<dl class="row mb-0">' + rows.map(([label, value]) =>
                `<dt class="col-sm-4">${label}</dt><dd class="col-sm-8">${value}</dd>`
            ).join('') + '</dl>';
        }
        summaryModal?.show();
    });

    updateSummary();
    updateProgress();
});
