<?php
/**
 * En-tête Commun & Navigation
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
require_once __DIR__ . '/../config.php';

// Détermination de la page active pour le menu
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EcoSmart Lab - Plateforme d'Innovations et de Gestion de Projets d'Ingénierie pour les étudiants de l'ECAM-EPMI (1AE).">
    <meta name="author" content="Étudiants 1AE - ECAM-EPMI">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' . APP_NAME : APP_NAME . ' - ' . APP_SUBTITLE ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚡</text></svg>">
    

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Styles CSS Personnalisés -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>

    <!-- Barre de Navigation Supérieure -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Logo & Nom -->
            <a class="navbar-brand" href="index.php">
                <div class="brand-icon">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <span><?= APP_NAME ?></span>
            </a>

            <!-- Boutons Mobiles (Dark Mode + Hamburger) -->
            <div class="d-flex align-items-center gap-2 d-lg-none">
                <button type="button" class="theme-toggle-btn js-theme-toggle" aria-label="Changer de thème">
                    <i class="bi bi-moon-stars-fill"></i>
                </button>
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Basculer la navigation">
                    <i class="bi bi-list fs-2"></i>
                </button>
            </div>

            <!-- Liens de Navigation -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'index.php') ? 'active' : '' ?>" href="index.php">
                            <i class="bi bi-house-door me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'projets.php') ? 'active' : '' ?>" href="projets.php">
                            <i class="bi bi-grid-fill me-1"></i> Projets & Innovations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'inscription.php') ? 'active' : '' ?>" href="inscription.php">
                            <i class="bi bi-plus-circle-fill me-1"></i> Déposer un Projet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'admin.php') ? 'active' : '' ?>" href="admin.php">
                            <i class="bi bi-table me-1"></i> Tableau de Bord (CRUD)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'a_propos.php') ? 'active' : '' ?>" href="a_propos.php">
                            <i class="bi bi-info-circle me-1"></i> À Propos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'contact.php') ? 'active' : '' ?>" href="contact.php">
                            <i class="bi bi-envelope me-1"></i> Contact
                        </a>
                    </li>
                </ul>

                <!-- Actions de droite (Dark Mode & Bouton CTA) -->
                <div class="d-none d-lg-flex align-items-center gap-3">
                    <button type="button" class="theme-toggle-btn js-theme-toggle" title="Basculer thème sombre / clair" aria-label="Basculer thème">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                    <a href="inscription.php" class="btn btn-primary btn-sm px-3 shadow-sm">
                        <i class="bi bi-lightning-fill"></i> Inscription Projet
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteneur Principal -->
    <main class="main-content">
        <div class="container mt-3">
            <?= display_flash() ?>

        </div>