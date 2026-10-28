<?php
/**
 * En-tete Commun & Navigation
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
require_once __DIR__ . '/../config.php';

// Determination de la page active pour le menu
$currentPage = basename($_SERVER['SCRIPT_NAME']);

// Liens du menu principal : libelle, icone et fichier cible
$navLinks = [
    ['file' => 'feed.php',        'label' => 'Feed',                   'icon' => 'bi-house-door'],
    ['file' => 'projets.php',     'label' => 'Projets & Innovations',  'icon' => 'bi-grid-fill'],
    ['file' => 'inscription.php', 'label' => 'Deposer un Projet',      'icon' => 'bi-plus-circle-fill'],
    ['file' => 'admin.php',       'label' => 'Tableau de Bord (CRUD)', 'icon' => 'bi-table'],
    ['file' => 'a_propos.php',    'label' => 'A Propos',               'icon' => 'bi-info-circle'],
    ['file' => 'contact.php',     'label' => 'Contact',                'icon' => 'bi-envelope'],
    ['file'=> 'login.php', 'label'=> 'connexion'],
];
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EcoSmart Lab - Plateforme dInnovations et de Gestion de Projets dIngenierie pour les etudiants de lECAM-EPMI (1AE).">
    <meta name="author" content="Etudiants 1AE - ECAM-EPMI">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' . APP_NAME : APP_NAME . ' - ' . APP_SUBTITLE ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">

    <!--
        Application du theme AVANT le rendu pour eviter le "flash blanc"
        au chargement d une page lorsque le mode sombre est actif.
    -->
    <script>
        (function () {
            var theme = 'light';
            try {
                var stored = localStorage.getItem('ecosmart-theme');
                if (stored === 'dark' || stored === 'light') {
                    theme = stored;
                } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    theme = 'dark';
                }
            } catch (e) {}
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles CSS Personnalises -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Barre de Navigation Superieure -->
    <nav class="navbar navbar-expand navbar-custom sticky-top">
        <div class="container">
            <!-- Logo & Nom -->
            <a class="navbar-brand" href="index.php">
                <div class="brand-icon">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <span><?= APP_NAME ?></span>
            </a>

            <!-- Liens de Navigation -->
            <div class="navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <?php foreach ($navLinks as $link): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentPage === $link['file']) ? 'active fw-semibold' : '' ?>"
                               href="<?= e($link['file']) ?>"
                               <?= ($currentPage === $link['file']) ? 'aria-current="page"' : '' ?>>
                                <i class="bi <?= e($link['icon']) ?> me-1"></i> <?= e($link['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Actions de droite (Dark Mode ) -->
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2 js-theme-toggle"
                            style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"
                            title="Basculer theme sombre / clair" aria-label="Basculer le theme">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteneur Principal -->
    <main class="main-content">
        <?php $flashHtml = display_flash(); ?>
        <?php if ($flashHtml !== ''): ?>
            <div class="container mt-3">
                <?= $flashHtml ?>
            </div>
        <?php endif; ?>
