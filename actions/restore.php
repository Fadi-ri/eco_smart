<?php
/**
 * Restaure un projet depuis la corbeille.
 */
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php?view=trash');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$csrfToken = $_POST['csrf_token'] ?? null;

if ($id === false) {
    set_flash('danger', 'Identifiant de projet invalide.');
    header('Location: ../admin.php?view=trash');
    exit;
}

if (!is_string($csrfToken) || !verify_csrf_token($csrfToken)) {
    set_flash('danger', 'Jeton de sécurité invalide. Merci de réessayer.');
    header('Location: ../admin.php?view=trash');
    exit;
}

try {
    $stmt = Database::getConnection()->prepare("
        UPDATE projets_inscriptions
        SET deleted_at = NULL
        WHERE id = :id AND deleted_at IS NOT NULL
    ");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() === 0) {
        set_flash('warning', 'Le projet est introuvable ou a déjà été restauré.');
    } else {
        set_flash('success', 'Le projet a été restauré.');
    }
} catch (PDOException $e) {
    error_log('Erreur de restauration du projet ' . $id . ' : ' . $e->getMessage());
    set_flash('danger', 'Impossible de restaurer le projet pour le moment.');
}

header('Location: ../admin.php?view=trash');
exit;
