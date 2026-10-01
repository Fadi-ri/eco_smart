<?php
// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nom de l'application
define('APP_NAME', 'EcoSmart Lab');
define('APP_SUBTITLE', 'Plateforme Projets ECAM-EPMI 1AE');
define('APP_YEAR', date('Y'));

// Connexion BDD et fonctions
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

