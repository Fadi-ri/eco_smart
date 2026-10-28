<?php
/**
 * Page Contact - Formulaire et coordonnees du laboratoire
 * EcoSmart Lab - ECAM-EPMI 1AE
 */

$pageTitle = "Contact";
require_once __DIR__ . '/config.php';

$csrfToken = generate_csrf_token();

// Valeurs re-injectees apres une erreur de validation
$old = take_old_input('contact_old');

$sujets = [
    'Depot de projet',
    'Partenariat industriel',
    'Acces au laboratoire',
    'Probleme technique',
    'Autre demande',
];

$contactInfos = [
    [
        'icon'  => 'bi-geo-alt-fill',
        'color' => 'bg-danger-subtle text-danger',
        'title' => 'Campus ECAM-EPMI',
        'lines' => ['13 Boulevard de lHautil', '95092 Cergy-Pontoise Cedex'],
        'link'  => null,
    ],
    [
        'icon'  => 'bi-envelope-fill',
        'color' => 'bg-primary-subtle text-primary',
        'title' => 'Email',
        'lines' => ['contact@ecam-epmi.com'],
        'link'  => 'mailto:contact@ecam-epmi.com',
    ],
    [
        'icon'  => 'bi-telephone-fill',
        'color' => 'bg-success-subtle text-success',
        'title' => 'Telephone',
        'lines' => ['+33 (0)1 30 75 60 40'],
        'link'  => 'tel:+33130756040',
    ],
    [
        'icon'  => 'bi-clock-fill',
        'color' => 'bg-warning-subtle text-warning',
        'title' => 'Horaires du laboratoire',
        'lines' => ['Lundi - Vendredi : 9h00 - 18h00', 'Ferme le week-end et jours feries'],
        'link'  => null,
    ],
];

$faq = [
    [
        'question' => 'Qui peut deposer un projet sur EcoSmart Lab ?',
        'answer'   => 'Tout etudiant inscrit a lECAM-EPMI, du cycle preparatoire au cycle ingenieur, ainsi que les enseignants-chercheurs encadrants. Les partenaires industriels peuvent proposer un sujet en passant par ce formulaire.',
    ],
    [
        'question' => 'Combien de temps dure la validation dun projet ?',
        'answer'   => 'Lequipe pedagogique examine les dossiers sous une a deux semaines. Le statut passe de "En attente" a "Valide" ou "Rejete" et reste consultable depuis le catalogue des projets.',
    ],
    [
        'question' => 'Comment obtenir un acces au laboratoire et aux equipements ?',
        'answer'   => 'Cochez la case "Besoin laboratoire" lors du depot de votre projet, puis contactez-nous via ce formulaire en choisissant le sujet "Acces au laboratoire" pour planifier un creneau.',
    ],
    [
        'question' => 'Puis-je modifier un projet deja depose ?',
        'answer'   => 'Oui. Les modifications se font depuis le tableau de bord (CRUD). Si votre projet a deja ete valide, envoyez-nous une demande afin que lencadrement reevalue le budget et le planning.',
    ],
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- En-tete de la page -->
<section class="pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Contact</span>
                <h1 class="display-5 fw-bold mb-3">Parlons de <span class="gradient-text">votre projet</span></h1>
                <p class="lead text-muted m-0">
                    Une question sur le depot dun projet, un partenariat industriel ou un acces aux equipements du
                    laboratoire ? Lequipe EcoSmart Lab vous repond sous 48 heures ouvrees.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Coordonnees -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($contactInfos as $info): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card-custom p-4 d-flex flex-row align-items-start gap-3">
                        <span class="card-icon-wrapper mb-0 flex-shrink-0 <?= $info['color'] ?>">
                            <i class="bi <?= $info['icon'] ?>"></i>
                        </span>
                        <div>
                            <h6 class="fw-bold mb-2"><?= e($info['title']) ?></h6>
                            <?php foreach ($info['lines'] as $line): ?>
                                <p class="small text-muted mb-1">
                                    <?php if ($info['link']): ?>
                                        <a href="<?= e($info['link']) ?>" class="link-body-emphasis text-decoration-none"><?= e($line) ?></a>
                                    <?php else: ?>
                                        <?= e($line) ?>
                                    <?php endif; ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Formulaire + carte -->
<section class="pb-5" id="formulaire">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <!-- Formulaire de contact -->
            <div class="col-lg-7">
                <div class="form-container">
                    <div class="form-step-header">
                        <span class="step-number"><i class="bi bi-pencil"></i></span>
                        <div>
                            <h2 class="h5 fw-bold m-0">Envoyer un message</h2>
                            <p class="text-muted small m-0">Les champs marques dun * sont obligatoires.</p>
                        </div>
                    </div>

                    <form action="actions/contact.php" method="POST" novalidate id="contactForm">
                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom complet *</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                       value="<?= old($old, 'nom') ?>"
                                       placeholder="Prenom NOM" minlength="2" maxlength="120" required>
                                <div class="invalid-feedback">Merci dindiquer votre nom (2 caracteres minimum).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse email *</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= old($old, 'email') ?>"
                                       placeholder="prenom.nom@epmi-edu.fr" maxlength="150" required>
                                <div class="invalid-feedback">Merci dindiquer une adresse email valide.</div>
                            </div>

                            <div class="col-12">
                                <label for="sujet" class="form-label">Sujet de la demande *</label>
                                <select class="form-select" id="sujet" name="sujet" required>
                                    <option value="">Choisir un sujet...</option>
                                    <?php foreach ($sujets as $sujet): ?>
                                        <option value="<?= e($sujet) ?>" <?= (($old['sujet'] ?? '') === $sujet) ? 'selected' : '' ?>>
                                            <?= e($sujet) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Merci de selectionner un sujet.</div>
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label">Votre message *</label>
                                <textarea class="form-control" id="message" name="message" rows="6"
                                          placeholder="Decrivez votre demande, votre projet ou votre question..."
                                          minlength="20" maxlength="2000" required><?= old($old, 'message') ?></textarea>
                                <div class="invalid-feedback">Le message doit contenir au moins 20 caracteres.</div>
                                <div class="text-end">
                                    <small class="text-muted"><span id="messageCounter">0</span> / 2000 caracteres</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rgpd" name="rgpd" value="1" required>
                                    <label class="form-check-label small text-muted" for="rgpd">
                                        Jaccepte que mes donnees soient utilisees pour traiter ma demande. Elles ne sont
                                        ni revendues ni transmises a des tiers. *
                                    </label>
                                    <div class="invalid-feedback">Cette autorisation est necessaire pour envoyer le message.</div>
                                </div>
                            </div>

                            <div class="col-12 d-flex flex-wrap gap-3 mt-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send-fill"></i> Envoyer le message
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reinitialiser
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Carte & acces -->
            <div class="col-lg-5">
                <div class="card-custom h-auto overflow-hidden mb-4">
                    <div class="ratio ratio-4x3">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=2.0530%2C49.0330%2C2.0770%2C49.0450&amp;layer=mapnik&amp;marker=49.0390%2C2.0650"
                            title="Localisation du campus ECAM-EPMI a Cergy-Pontoise"
                            style="border: 0;"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <p class="small text-muted mb-4">
                    <i class="bi bi-box-arrow-up-right me-1"></i>
                    <a href="https://www.openstreetmap.org/?mlat=49.0390&amp;mlon=2.0650#map=16/49.0390/2.0650"
                       target="_blank" rel="noopener">Ouvrir le plan dans OpenStreetMap</a>
                    si la carte ne saffiche pas.
                </p>

                <div class="card-custom h-auto p-4">
                    <h3 class="h6 fw-bold mb-3">
                        <i class="bi bi-signpost-split-fill text-primary me-1"></i> Venir au laboratoire
                    </h3>
                    <ul class="list-unstyled small text-muted d-grid gap-3 m-0">
                        <li class="d-flex gap-2">
                            <i class="bi bi-train-front-fill text-primary"></i>
                            <span>RER A jusqua <strong>Cergy-Prefecture</strong>, puis 10 minutes a pied.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <i class="bi bi-bus-front-fill text-success"></i>
                            <span>Bus lignes 34 / 48, arret <strong>Parvis de la Prefecture</strong>.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <i class="bi bi-p-circle-fill text-warning"></i>
                            <span>Parking visiteurs gratuit sur presentation dune piece didentite a laccueil.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <i class="bi bi-person-badge-fill text-danger"></i>
                            <span>Lacces aux salles techniques necessite un encadrant referent.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Questions frequentes -->
<section class="pb-5">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">FAQ</span>
                <h2 class="fw-bold mb-2">Questions frequentes</h2>
                <p class="text-muted m-0">Votre reponse se trouve peut-etre deja ici.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faq as $index => $item): ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="faqHeading<?= $index ?>">
                                <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faqCollapse<?= $index ?>"
                                        aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                                        aria-controls="faqCollapse<?= $index ?>">
                                    <?= e($item['question']) ?>
                                </button>
                            </h3>
                            <div id="faqCollapse<?= $index ?>"
                                 class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                 aria-labelledby="faqHeading<?= $index ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small"><?= e($item['answer']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Validation live du formulaire de contact
$extraScripts = ['js/contact-validation.js'];
require_once __DIR__ . '/includes/footer.php';
?>
