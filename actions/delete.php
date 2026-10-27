<?php
/**
 * Traitement de la suppression d'un projet.
 */
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php');
    exit;
}

// La suppression exige un identifiant valide et un jeton CSRF correspondant à la session.
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$csrfToken = $_POST['csrf_token'] ?? null;

if ($id === false) {
    set_flash('danger', 'Identifiant de projet invalide.');
    header('Location: ../admin.php');
    exit;
}

if (!is_string($csrfToken) || !verify_csrf_token($csrfToken)) {
    set_flash('danger', 'Jeton de sécurité invalide. Merci de réessayer.');
    header('Location: ../admin.php');
    exit;
}

try {
    // Requête préparée : l'identifiant est transmis séparément de la requête SQL.
    $stmt = Database::getConnection()->prepare('DELETE FROM projets_inscriptions WHERE id = :id');
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() === 0) {
        set_flash('warning', 'Le projet est introuvable ou a déjà été supprimé.');
    } else {
        set_flash('success', 'Le projet a été supprimé.');
    }
} catch (PDOException $e) {
    error_log('Erreur de suppression du projet ' . $id . ' : ' . $e->getMessage());
    set_flash('danger', 'Impossible de supprimer le projet pour le moment.');
}

header('Location: ../admin.php');
exit;
