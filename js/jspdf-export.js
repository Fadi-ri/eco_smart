function generateProjectPDF() {
    if (typeof window.jspdf === 'undefined') {
        alert('Le module de generation PDF nest pas disponible.');
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const getText = (id) => document.getElementById(id)?.textContent?.trim() || '-';

    doc.setFontSize(16);
    doc.text('Fiche Recapitulative - EcoSmart Lab', 14, 20);

    doc.setFontSize(11);
    const rows = [
        ['Porteur', getText('sum_nom')],
        ['Email', getText('sum_email')],
        ['Promotion', getText('sum_niveau')],
        ['Filiere', getText('sum_filiere')],
        ['Projet', getText('sum_titre')],
        ['Type', getText('sum_type')],
        ['Budget', getText('sum_budget')],
        ['Planning', getText('sum_date')],
        ['Acces Labo', getText('sum_labo')],
        ['Domaines', getText('sum_domaines')],
    ];

    let y = 35;
    rows.forEach(([label, value]) => {
        doc.setFont(undefined, 'bold');
        doc.text(`${label} :`, 14, y);
        doc.setFont(undefined, 'normal');
        doc.text(String(value), 60, y);
        y += 8;
    });

    doc.save('fiche-projet-ecosmart-lab.pdf');
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btnGeneratePDF')?.addEventListener('click', generateProjectPDF);
});
