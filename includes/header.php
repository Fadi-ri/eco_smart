<?php
/**
 * En-tete Commun & Navigation
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
require_once __DIR__ . '/../config.php';

// Determination de la page active pour le menu
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EcoSmart Lab - Plateforme dInnovations et de Gestion de Projets dIngenierie pour les etudiants de lECAM-EPMI (1AE).">
    <meta name="author" content="Etudiants 1AE - ECAM-EPMI">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' . APP_NAME : APP_NAME . ' - ' . APP_SUBTITLE ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
    

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Styles CSS Personnalises -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

    <!-- Barre de Navigation Superieure -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Logo & Nom -->
            <a class="navbar-brand" href="index.php">
                <div class="brand-icon">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <span><?= APP_NAME ?></span>
            </a>


            <!-- Liens de Navigation -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'feed.php') ? 'active' : '' ?>" href="feed.php">
                            <i class="bi bi-house-door me-1"></i> Feed 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'projets.php') ? 'active' : '' ?>" href="projets.php">
                            <i class="bi bi-grid-fill me-1"></i> Projets & Innovations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'inscription.php') ? 'active' : '' ?>" href="inscription.php">
                            <i class="bi bi-plus-circle-fill me-1"></i> Deposer un Projet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'admin.php') ? 'active' : '' ?>" href="admin.php">
                            <i class="bi bi-table me-1"></i> Tableau de Bord (CRUD)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'a_propos.php') ? 'active' : '' ?>" href="a_propos.php">
                            <i class="bi bi-info-circle me-1"></i> A Propos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>" href="contact.php">
                            <i class="bi bi-envelope me-1"></i> Contact
                        </a>
                    </li>
                </ul>

                <!-- Actions de droite (Dark Mode ) -->
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <button type="button" class="theme-toggle-btn js-theme-toggle" title="Basculer theme sombre / clair" aria-label="Basculer theme">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteneur Principal -->
    <main class="main-content">
        <div class="container mt-3">
            <?= display_flash() ?>

        </div>

