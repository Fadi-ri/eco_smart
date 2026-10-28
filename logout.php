<?php
session_start();

// Supprimer les informations de connexion
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header('Location: login.php');
exit;
?>