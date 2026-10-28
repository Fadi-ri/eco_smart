<?php
/**
 * Page "A Propos" - Presentation du projet, de lequipe et de la demarche
 * EcoSmart Lab - ECAM-EPMI 1AE
 */

$pageTitle = "A Propos du EcoSmart Lab";
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();

// Quelques chiffres pour illustrer lactivite reelle de la plateforme
$fallbackStats = [
    'total' => 5, 'valide' => 2, 'en_cours' => 1,
    'en_attente' => 1, 'termine' => 1, 'budget_total' => 13100.00,
];

$stats = $fallbackStats;
if ($pdo) {
    try {
        $stats = get_project_stats($pdo);
    } catch (Exception $e) {
        $stats = $fallbackStats;
    }
}

// Lequipe projet (RAN 1AE)
$team = [
    [
        'initials' => 'FR',
        'name'     => 'Fadi REZIG',
        'role'     => 'Chef de projet - Back-end & Securite',
        'tasks'    => ['Architecture & base de donnees', 'Formulaire et traitements PHP', 'CSRF, hachage, echappement'],
    ],
    [
        'initials' => 'DC',
        'name'     => 'Damian CAMELAYE',
        'role'     => 'Developpeur - Authentification',
        'tasks'    => ['Connexion & inscription', 'Validation des identifiants', 'Gestion des sessions'],
    ],
    [
        'initials' => 'KY',
        'name'     => 'Drubea konhu	',
        'role'     => 'Designer UI / UX',
        'tasks'    => ['Identite visuelle & maquettes Figma', 'Palette de couleurs', 'Theme clair / sombre'],
    ],
    [
        'initials'=> 'ON',
        'name'=> 'Oral Nzenque',
        'role'=>'Developpeur',
        'tasks' => ['CRUDE front-end', 'CRUDE back-end','CRUDE design']
        ],
];

// Frise des grandes etapes du projet
$milestones = [
    [
        'date'  => 'Septembre 2026',
        'title' => 'Cadrage & cahier des charges',
        'text'  => 'Choix du sujet en equipe, redaction du cahier des charges, conception du modele de donnees et mise en place du depot Git.',
    ],
    [
        'date'  => '08 Octobre 2026',
        'title' => 'Identite visuelle & maquettes',
        'text'  => 'Definition de la charte graphique sur Figma : en-tete, pied de page, page daccueil, feed et formulaire de depot.',
    ],
    [
        'date'  => '16 Octobre 2026',
        'title' => 'Socle fonctionnel',
        'text'  => 'Navigation complete entre les pages, catalogue des projets, formulaire en 3 etapes, export PDF et authentification.',
    ],
    [
        'date'  => '27 Octobre 2026',
        'title' => 'Finalisation de lexperience',
        'text'  => 'Page daccueil complete, pages A Propos et Contact, theme sombre persistant et adaptation mobile.',
    ],
];

// Valeurs mises en avant par le laboratoire
$values = [
    ['icon' => 'bi-recycle',         'color' => 'bg-success-subtle text-success', 'title' => 'Eco-responsabilite',  'text' => 'Chaque projet est evalue sur son impact energetique et environnemental, de la conception au prototype.'],
    ['icon' => 'bi-people-fill',     'color' => 'bg-primary-subtle text-primary', 'title' => 'Collaboration',       'text' => 'Les travaux sont partages entre promotions et filieres pour eviter de repartir de zero a chaque semestre.'],
    ['icon' => 'bi-lightbulb-fill',  'color' => 'bg-warning-subtle text-warning', 'title' => 'Innovation',          'text' => 'Des prototypes concrets : micro-reseaux solaires, robotique dinspection, jumeaux numeriques, IA predictive.'],
    ['icon' => 'bi-journal-text',    'color' => 'bg-info-subtle text-info',       'title' => 'Transparence',        'text' => 'Budget, planning et statut davancement sont visibles publiquement pour chaque initiative deposee.'],
];

// Technologies utilisees pour construire la plateforme
$stack = [
    ['icon' => 'bi-filetype-html', 'name' => 'HTML5',        'desc' => 'Structure semantique et accessible'],
    ['icon' => 'bi-filetype-css',  'name' => 'CSS3',         'desc' => 'Variables CSS, theme clair / sombre'],
    ['icon' => 'bi-bootstrap',     'name' => 'Bootstrap 5.3','desc' => 'Grille responsive et composants'],
    ['icon' => 'bi-filetype-js',   'name' => 'JavaScript',   'desc' => 'Validation live, filtres, animations'],
    ['icon' => 'bi-filetype-php',  'name' => 'PHP 8',        'desc' => 'Traitements serveur et securite'],
    ['icon' => 'bi-database-fill', 'name' => 'MySQL',        'desc' => 'PDO, requetes preparees, repli SQLite'],
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- En-tete de la page -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <span>Projet Developpement Web • RAN 1AE</span>
                </div>
                <h1 class="hero-title">
                    Un laboratoire etudiant dedie a
                    <span class="gradient-text">lingenierie durable</span>
                </h1>
                <p class="hero-lead">
                    EcoSmart Lab est la plateforme collaborative des etudiants de lECAM-EPMI. Elle centralise le depot,
                    le suivi et la valorisation des projets techniques : energies renouvelables, intelligence artificielle,
                    robotique, mobilite electrique et genie industriel.
                </p>
                <div class="d-flex flex-wrap gap-3 hero-buttons">
                    <a href="projets.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-compass"></i> Voir les projets
                    </a>
                    <a href="contact.php" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-visual">
                    <span class="hero-visual-ring"></span>
                    <h2 class="h6 fw-bold mb-3">
                        <i class="bi bi-bullseye text-primary me-1"></i> Le Lab en chiffres
                    </h2>

                    <div class="hero-metric">
                        <span class="hero-metric-icon bg-primary-subtle text-primary"><i class="bi bi-folder2-open"></i></span>
                        <div>
                            <div class="hero-metric-value js-counter" data-target="<?= (int) $stats['total'] ?>"><?= counter_value((int) $stats['total']) ?></div>
                            <div class="hero-metric-label">Projets referencees</div>
                        </div>
                    </div>

                    <div class="hero-metric">
                        <span class="hero-metric-icon bg-success-subtle text-success"><i class="bi bi-cash-coin"></i></span>
                        <div>
                            <div class="hero-metric-value js-counter" data-target="<?= (int) $stats['budget_total'] ?>" data-suffix=" €"><?= counter_value((int) $stats['budget_total'], ' €') ?></div>
                            <div class="hero-metric-label">Budget cumule accompagne</div>
                        </div>
                    </div>

                    <div class="hero-metric">
                        <span class="hero-metric-icon bg-warning-subtle text-warning"><i class="bi bi-diagram-3"></i></span>
                        <div>
                            <div class="hero-metric-value js-counter" data-target="5"><?= counter_value(5) ?></div>
                            <div class="hero-metric-label">Poles dingenierie</div>
                        </div>
                    </div>

                    <div class="hero-metric">
                        <span class="hero-metric-icon bg-info-subtle text-info"><i class="bi bi-people"></i></span>
                        <div>
                            <div class="hero-metric-value js-counter" data-target="<?= count($team) ?>"><?= counter_value(count($team)) ?></div>
                            <div class="hero-metric-label">Membres de lequipe projet</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Objectifs -->
<section class="section-padded">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <span class="section-eyebrow">Notre mission</span>
                <h2 class="section-title">Donner une vie apres la soutenance aux projets etudiants</h2>
                <p class="text-muted">
                    Chaque annee, des dizaines de prototypes, maquettes et travaux de recherche sont realises a lECAM-EPMI,
                    puis oublies dans un disque dur. EcoSmart Lab a ete concu pour rompre ce cycle : un espace unique ou
                    chaque projet est decrit, documente, suivi et consultable par les promotions suivantes.
                </p>
                <ul class="list-unstyled d-grid gap-3 mt-4">
                    <li class="d-flex gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span><strong>Centraliser</strong> le depot des projets dans un formulaire unique et structure.</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span><strong>Suivre</strong> lavancement, le budget et le statut de validation de chaque initiative.</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span><strong>Valoriser</strong> les realisations aupres des enseignants, partenaires et futurs etudiants.</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span><strong>Mutualiser</strong> les ressources du laboratoire entre filieres et promotions.</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6">
                <div class="row g-4">
                    <?php foreach ($values as $value): ?>
                        <div class="col-md-6 reveal-on-scroll">
                            <div class="card-custom p-4">
                                <span class="card-icon-wrapper <?= $value['color'] ?>">
                                    <i class="bi <?= $value['icon'] ?>"></i>
                                </span>
                                <h5 class="fw-bold mb-2"><?= e($value['title']) ?></h5>
                                <p class="text-muted small m-0"><?= e($value['text']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Frise chronologique du projet -->
<section class="section-padded">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <span class="section-eyebrow">Historique</span>
                <h2 class="section-title">Les etapes du developpement</h2>
                <p class="section-subtitle">
                    EcoSmart Lab est un projet pedagogique mene sur le semestre dans le cadre du module
                    Developpement Web du cycle preparatoire ingenieur (RAN - 1AE).
                </p>
                <a href="https://github.com/Fadi-ri/eco_smart" target="_blank" rel="noopener" class="btn btn-outline-primary mt-3">
                    <i class="bi bi-github"></i> Consulter le depot Git
                </a>
            </div>

            <div class="col-lg-7">
                <div class="timeline">
                    <?php foreach ($milestones as $milestone): ?>
                        <div class="timeline-item reveal-on-scroll">
                            <span class="timeline-date"><?= e($milestone['date']) ?></span>
                            <h5 class="timeline-title"><?= e($milestone['title']) ?></h5>
                            <p class="timeline-text"><?= e($milestone['text']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lequipe -->
<section class="section-padded">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Lequipe</span>
            <h2 class="section-title">Qui developpe EcoSmart Lab ?</h2>
            <p class="section-subtitle">
                Une equipe detudiants de 1ere annee du cycle ingenieur, repartie sur la conception, le developpement et la securite.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php foreach ($team as $member): ?>
                <div class="col-lg-4 col-md-6 reveal-on-scroll">
                    <div class="team-card">
                        <div class="team-avatar"><?= e($member['initials']) ?></div>
                        <h5 class="team-name"><?= e($member['name']) ?></h5>
                        <p class="team-role mb-3"><?= e($member['role']) ?></p>
                        <ul class="list-unstyled text-start small text-muted m-0">
                            <?php foreach ($member['tasks'] as $task): ?>
                                <li class="mb-1">
                                    <i class="bi bi-dot text-primary"></i> <?= e($task) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Stack technique -->
<section class="section-padded">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">Technologies</span>
            <h2 class="section-title">Comment la plateforme est construite</h2>
            <p class="section-subtitle">
                Un developpement sans framework back-end, pour maitriser chaque couche : du HTML semantique jusqua la requete preparee.
            </p>
        </div>

        <div class="row g-4">
            <?php foreach ($stack as $tech): ?>
                <div class="col-lg-4 col-md-6 reveal-on-scroll">
                    <div class="card-custom p-4 d-flex align-items-center gap-3">
                        <span class="card-icon-wrapper bg-primary-subtle text-primary mb-0">
                            <i class="bi <?= $tech['icon'] ?>"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-1"><?= e($tech['name']) ?></h5>
                            <p class="text-muted small m-0"><?= e($tech['desc']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Appel a laction -->
<section class="section-padded">
    <div class="container">
        <div class="cta-banner reveal-on-scroll">
            <h2>Une question sur le laboratoire ?</h2>
            <p>
                Etudiant, enseignant ou partenaire industriel : lequipe EcoSmart Lab repond a vos demandes
                de collaboration, dencadrement ou dacces aux equipements.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="contact.php" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope-fill"></i> Ecrire a lequipe
                </a>
                <a href="inscription.php" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-rocket-takeoff-fill"></i> Deposer un projet
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
