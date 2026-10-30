<?php
/**
 * Page dAccueil - EcoSmart Lab
 * ECAM-EPMI 1AE - Projet Web
 */
/*hello c damian*/

$pageTitle = "Accueil & Innovations Ingenieurs";
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();

// Statistiques globales (valeurs de demonstration si la base est indisponible)
$fallbackStats = [
    'total' => 5,
    'valide' => 2,
    'en_cours' => 1,
    'en_attente' => 1,
    'termine' => 1,
    'budget_total' => 13100.00,
];

$stats = $fallbackStats;
if ($pdo) {
    try {
        $stats = get_project_stats($pdo);
    } catch (Exception $e) {
        $stats = $fallbackStats;
    }
}

// Recuperation des 3 derniers projets recents
$recentProjects = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `projets_inscriptions` ORDER BY id DESC LIMIT 3");
        $recentProjects = $stmt->fetchAll();
    } catch (Exception $e) {}
}

// Poles dingenierie : lus en base, avec repli statique si la table est absente
$thematiques = [];
if ($pdo) {
    try {
        $thematiques = $pdo->query("SELECT * FROM `thematiques` ORDER BY id ASC")->fetchAll();
    } catch (Exception $e) {}
}

if (!$thematiques) {
    $thematiques = [
        ['nom' => 'Energie & Developpement Durable',    'description' => 'Solutions solaires, reseaux intelligents (Smart Grids), hydrogene vert et optimisation energetique.', 'icone' => 'bi-lightning-charge', 'couleur' => '#20c997'],
        ['nom' => 'Systemes dInformation & IA',         'description' => 'Intelligence artificielle, Machine Learning, Big Data, Cloud Computing et Cybersecurite.', 'icone' => 'bi-cpu', 'couleur' => '#0d6efd'],
        ['nom' => 'Robotique & Systemes Embarques',     'description' => 'Drones autonomes, bras robotiques, IoT industriel, microcontroleurs STM32 et Arduino.', 'icone' => 'bi-robot', 'couleur' => '#fd7e14'],
        ['nom' => 'Mobilite Electrique & Smart Cities', 'description' => 'Vehicules electriques, bornes intelligentes, capteurs urbains et gestion du trafic.', 'icone' => 'bi-ev-front', 'couleur' => '#6f42c1'],
        ['nom' => 'Genie Industriel & 4.0',             'description' => 'Automatisation industrielle, jumeaux numeriques, logistique connectee et lean manufacturing.', 'icone' => 'bi-gear-wide-connected', 'couleur' => '#d63384'],
    ];
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-primary-subtle text-primary fw-semibold rounded-pill px-3 py-2 mb-3">
                    <i class="bi bi-patch-check-fill"></i> ECAM-EPMI • Cycle Ingenieur
                </span>
                <h1 class="display-4 fw-bold lh-1 mb-3">
                    L'Innovation Technologique  <br>
                    <span class="gradient-text">L'Ingenierie Durable Eco-Responsable</span>
                </h1>
                <p class="lead text-muted mb-4">
                    Plateforme collaborative centralisant les projets de recherche, prototypes industriels, maquettes IoT et innovations en energie des etudiants et chercheurs de lECAM-EPMI.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="inscription.php" class="btn btn-primary btn-lg shadow">
                        <i class="bi bi-rocket-takeoff-fill"></i> Deposer un Projet
                    </a>
                    <a href="projets.php" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-compass"></i> Explorer les Projets
                    </a>
                    <a href="admin.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-table"></i> Dashboard CRUD
                    </a>
                </div>
            </div>

            <!-- Carte de synthese illustrant lactivite du laboratoire -->
            <div class="col-lg-5">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="h6 fw-bold m-0">
                            <i class="bi bi-activity text-primary me-1"></i> Activite du Lab
                        </h2>
                        <span class="badge bg-success-subtle text-success small">
                            <i class="bi bi-broadcast pulse-glow"></i> En direct
                        </span>
                    </div>

                    <?php
                    $heroMetrics = [
                        ['icon' => 'bi-folder2-open', 'class' => 'bg-primary-subtle text-primary', 'value' => (int) $stats['total'],        'suffix' => '',   'label' => 'Projets deposes sur la plateforme'],
                        ['icon' => 'bi-patch-check',  'class' => 'bg-success-subtle text-success', 'value' => (int) $stats['valide'],       'suffix' => '',   'label' => 'Projets valides par lencadrement'],
                        ['icon' => 'bi-cash-coin',    'class' => 'bg-warning-subtle text-warning', 'value' => (int) $stats['budget_total'], 'suffix' => ' €', 'label' => 'Budget cumule des initiatives'],
                        ['icon' => 'bi-diagram-3',    'class' => 'bg-info-subtle text-info',       'value' => count($thematiques),          'suffix' => '',   'label' => 'Poles dingenierie couverts'],
                    ];
                    $lastMetric = array_key_last($heroMetrics);
                    ?>
                    <?php foreach ($heroMetrics as $key => $metric): ?>
                        <div class="d-flex align-items-center gap-3 py-3 <?= $key === $lastMetric ? 'pb-0' : 'border-bottom' ?>">
                            <span class="card-icon-wrapper mb-0 flex-shrink-0 <?= $metric['class'] ?>">
                                <i class="bi <?= $metric['icon'] ?>"></i>
                            </span>
                            <div>
                                <div class="h4 fw-bold mb-0 js-counter"
                                     data-target="<?= $metric['value'] ?>"
                                     <?= $metric['suffix'] !== '' ? 'data-suffix="' . e($metric['suffix']) . '"' : '' ?>><?= counter_value($metric['value'], $metric['suffix']) ?></div>
                                <div class="small text-muted"><?= e($metric['label']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques detaillees par statut -->
<section class="py-5">
    <div class="container">
        <div class="row g-3 g-md-4">
            <?php
            $statCards = [
                ['label' => 'Projets au total', 'value' => (int) $stats['total'],      'icon' => 'bi-collection-fill',  'class' => 'bg-primary-subtle text-primary'],
                ['label' => 'Valides',          'value' => (int) $stats['valide'],     'icon' => 'bi-patch-check-fill', 'class' => 'bg-success-subtle text-success'],
                ['label' => 'En cours',         'value' => (int) $stats['en_cours'],   'icon' => 'bi-hourglass-split',  'class' => 'bg-info-subtle text-info'],
                ['label' => 'En attente',       'value' => (int) $stats['en_attente'], 'icon' => 'bi-clock-history',    'class' => 'bg-warning-subtle text-warning'],
                ['label' => 'Termines',         'value' => (int) $stats['termine'],    'icon' => 'bi-flag-fill',        'class' => 'bg-secondary-subtle text-secondary'],
            ];
            ?>
            <?php foreach ($statCards as $card): ?>
                <div class="col-6 col-md-4 col-lg">
                    <div class="card-custom p-4 text-center">
                        <span class="card-icon-wrapper mx-auto <?= $card['class'] ?>">
                            <i class="bi <?= $card['icon'] ?>"></i>
                        </span>
                        <p class="h2 fw-bold mb-1 js-counter" data-target="<?= $card['value'] ?>"><?= counter_value($card['value']) ?></p>
                        <p class="small text-muted m-0"><?= e($card['label']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Poles dIngenierie -->
<section class="py-5" id="poles">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Thematiques</span>
                <h2 class="fw-bold mb-2">Les Poles dIngenierie du Lab</h2>
                <p class="text-muted m-0">
                    Chaque projet depose est rattache a lun des cinq axes technologiques majeurs du cycle ingenieur ECAM-EPMI.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($thematiques as $theme): ?>
                <div class="col-lg-4 col-md-6">
                    <a class="card-custom p-4 d-block text-decoration-none" href="projets.php?filiere=<?= urlencode($theme['nom']) ?>">
                        <span class="card-icon-wrapper"
                              style="background: <?= e($theme['couleur']) ?>1f; color: <?= e($theme['couleur']) ?>;">
                            <i class="bi <?= e($theme['icone']) ?>"></i>
                        </span>
                        <h5 class="fw-bold mb-2"><?= e($theme['nom']) ?></h5>
                        <p class="text-muted small mb-3"><?= e($theme['description']) ?></p>
                        <span class="small fw-semibold text-primary">
                            Voir les projets <i class="bi bi-arrow-right"></i>
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Derniers projets deposes -->
<?php if (!empty($recentProjects)): ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Nouveautes</span>
                <h2 class="fw-bold mb-1">Derniers Projets Deposes</h2>
                <p class="text-muted m-0">Les initiatives les plus recemment soumises par la communaute.</p>
            </div>
            <a href="projets.php" class="btn btn-outline-primary">
                <i class="bi bi-grid-3x3-gap"></i> Tout le catalogue
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($recentProjects as $project): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <span class="badge bg-primary-subtle text-primary small fw-semibold">
                                <i class="bi bi-tag-fill me-1"></i> <?= e($project['type_projet']) ?>
                            </span>
                            <?= get_status_badge((string) ($project['statut'] ?? 'En attente')) ?>
                        </div>

                        <h5 class="fw-bold mt-2 mb-2 text-truncate-2" title="<?= e($project['titre_projet']) ?>">
                            <?= e($project['titre_projet']) ?>
                        </h5>

                        <div class="small text-muted mb-2">
                            <i class="bi bi-mortarboard me-1"></i>
                            <?= e($project['filiere']) ?> (<?= e($project['niveau_etudes']) ?>)
                        </div>

                        <p class="text-muted small flex-grow-1 line-clamp-3">
                            <?= e($project['description']) ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2 small">
                            <span class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= e($project['prenom'] . ' ' . $project['nom']) ?>
                            </span>
                            <span class="fw-semibold text-success">
                                <?= format_currency((float) ($project['budget_estime'] ?? 0)) ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Comment deposer un projet -->
<section class="py-5" id="demarche">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Demarche</span>
                <h2 class="fw-bold mb-2">Deposer un Projet en 4 Etapes</h2>
                <p class="text-muted m-0">
                    Un parcours simple, de lidee initiale jusqua la validation par lequipe pedagogique.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <?php
            $steps = [
                ['icon' => 'bi-lightbulb-fill', 'title' => 'Formaliser lidee',    'text' => 'Definissez la problematique technique, les objectifs et les livrables attendus de votre projet.'],
                ['icon' => 'bi-ui-checks',      'title' => 'Remplir le dossier',  'text' => 'Completez le formulaire : filiere, domaines cles, budget estime, planning et besoin de laboratoire.'],
                ['icon' => 'bi-shield-check',   'title' => 'Validation',          'text' => 'Lequipe pedagogique examine la faisabilite du projet et attribue les ressources necessaires.'],
                ['icon' => 'bi-graph-up-arrow', 'title' => 'Suivi & Publication', 'text' => 'Suivez lavancement depuis le tableau de bord et publiez vos resultats dans le catalogue.'],
            ];
            ?>
            <?php foreach ($steps as $index => $step): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card-custom p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="step-number flex-shrink-0"><?= $index + 1 ?></span>
                            <span class="card-icon-wrapper mb-0 bg-primary-subtle text-primary">
                                <i class="bi <?= $step['icon'] ?>"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold mb-2"><?= e($step['title']) ?></h5>
                        <p class="text-muted small m-0"><?= e($step['text']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Appel a laction final -->
<section class="py-5">
    <div class="container">
        <div class="text-bg-primary rounded-4 text-center p-5">
            <h2 class="fw-bold mb-3">Vous avez une idee dinnovation ?</h2>
            <p class="mb-4 mx-auto max-w-700">
                Rejoignez les etudiants et chercheurs de lECAM-EPMI qui concretisent leurs projets techniques au sein du EcoSmart Lab.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="inscription.php" class="btn btn-light btn-lg">
                    <i class="bi bi-rocket-takeoff-fill"></i> Deposer mon projet
                </a>
                <a href="contact.php" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-envelope-fill"></i> Contacter lequipe
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
