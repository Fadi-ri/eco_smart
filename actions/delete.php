<?php
/**
 * Déplacement d'un projet dans la corbeille.
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
    // L'archivage conserve les données du projet pour permettre sa restauration.
    $stmt = Database::getConnection()->prepare("
        UPDATE projets_inscriptions
        SET deleted_at = CURRENT_TIMESTAMP
        WHERE id = :id AND deleted_at IS NULL
    ");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() === 0) {
        set_flash('warning', 'Le projet est introuvable ou se trouve déjà dans la corbeille.');
    } else {
        set_flash('success', 'Le projet a été déplacé dans la corbeille.');
    }
} catch (PDOException $e) {
    error_log('Erreur d’archivage du projet ' . $id . ' : ' . $e->getMessage());
    set_flash('danger', 'Impossible de déplacer le projet dans la corbeille pour le moment.');
}

header('Location: ../admin.php');
exit;
