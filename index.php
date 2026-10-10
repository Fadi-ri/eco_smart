<?php
/**
 * Page dAccueil - EcoSmart Lab
 * ECAM-EPMI 1AE - Projet Web
 */
/*hello c damian*/

$pageTitle = "Accueil & Innovations Ingenieurs";
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();
$stats = $pdo ? get_project_stats($pdo) : [
    'total' => 5,
    'valide' => 2,
    'en_cours' => 1,
    'en_attente' => 1,
    'termine' => 1,
    'budget_total' => 13100.00
];

// Recuperation des 3 derniers projets recents
$recentProjects = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `projets_inscriptions` ORDER BY id DESC LIMIT 3");
        $recentProjects = $stmt->fetchAll();
    } catch (Exception $e) {}
}

require_once __DIR__ . '/includes/hearder.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill text-primary"></i>
                    <span>ECAM-EPMI • Cycle Ingenieur </span>
                </div>
                <h1 class="hero-title">
                    LInnovation Technologique & <br>
                    <span class="gradient-text">LIngenierie Durable Eco-Responsable</span>
                </h1>
                <p class="hero-lead">
                    Plateforme collaborative centralisant les projets de recherche, prototypes industriels, maquettes IoT et innovations en energie des etudiants et chercheurs de lECAM-EPMI.
                </p>
                <div class="d-flex flex-wrap gap-3 hero-buttons">
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
