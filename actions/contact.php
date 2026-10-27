<?php
/**
 * Traitement du Formulaire de Contact
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
require_once __DIR__ . '/../config.php';
$pdo = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    set_flash('danger', 'Jeton de securite invalide, merci de reessayer.');
    header('Location: ../contact.php');
    exit;
}

$nom     = trim($_POST['nom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$sujet   = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');
$rgpd    = isset($_POST['rgpd']);

// Conservation des valeurs saisies pour re-remplir le formulaire en cas derreur
$_SESSION['contact_old'] = [
    'nom'     => $nom,
    'email'   => $email,
    'sujet'   => $sujet,
    'message' => $message,
];

// Validation cote serveur (le JS ne remplace jamais ces controles)
$errors = [];

if ($nom === '' || mb_strlen($nom) < 2) {
    $errors[] = 'Le nom doit contenir au moins 2 caracteres.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ladresse email nest pas valide.';
}

$sujetsAutorises = [
    'Depot de projet',
    'Partenariat industriel',
    'Acces au laboratoire',
    'Probleme technique',
    'Autre demande',
];

if (!in_array($sujet, $sujetsAutorises, true)) {
    $errors[] = 'Merci de choisir un sujet dans la liste.';
}

if (mb_strlen($message) < 20) {
    $errors[] = 'Le message doit contenir au moins 20 caracteres.';
}

if (mb_strlen($message) > 2000) {
    $errors[] = 'Le message ne doit pas depasser 2000 caracteres.';
}

if (!$rgpd) {
    $errors[] = 'Vous devez accepter le traitement de vos donnees pour envoyer le message.';
}

if ($errors) {
    set_flash('danger', implode(' ', $errors));
    header('Location: ../contact.php#formulaire');
    exit;
}

try {
    ensure_contact_table($pdo);

    $stmt = $pdo->prepare("
        INSERT INTO `messages_contact` (`nom`, `email`, `sujet`, `message`)
        VALUES (:nom, :email, :sujet, :message)
    ");

    $stmt->execute([
        ':nom'     => $nom,
        ':email'   => $email,
        ':sujet'   => $sujet,
        ':message' => $message,
    ]);
} catch (Exception $e) {
    set_flash('danger', 'Erreur lors de lenvoi du message : ' . $e->getMessage());
    header('Location: ../contact.php#formulaire');
    exit;
}

// Succes : on efface les anciennes valeurs pour repartir sur un formulaire vide
unset($_SESSION['contact_old']);

set_flash('success', 'Merci ' . $nom . ', votre message a bien ete envoye. Lequipe vous repond sous 48h.');
header('Location: ../contact.php');
exit;
