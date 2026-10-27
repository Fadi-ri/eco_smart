<?php
/**
 * Traitement de la modification d'un projet.
 */
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin.php');
    exit;
}

// Valide l'identifiant et le jeton CSRF avant de traiter les données envoyées.
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$csrfToken = $_POST['csrf_token'] ?? null;

if ($id === false) {
    set_flash('danger', 'Identifiant de projet invalide.');
    header('Location: ../admin.php');
    exit;
}

if (!is_string($csrfToken) || !verify_csrf_token($csrfToken)) {
    set_flash('danger', 'Jeton de sécurité invalide. Merci de réessayer.');
    header('Location: ../admin.php?edit=' . $id);
    exit;
}

$fields = [
    'nom' => 100,
    'prenom' => 100,
    'email' => 150,
    'telephone' => 30,
    'niveau_etudes' => 50,
    'filiere' => 150,
    'titre_projet' => 200,
    'type_projet' => 80,
    'domaines_cles' => null,
    'description' => null,
    'budget_estime' => null,
    'date_debut' => null,
    'duree_semaines' => null,
    'besoin_laboratoire' => null,
    'statut' => null,
];

// Ne récupère que des chaînes de caractères et retire les espaces superflus.
$values = [];
foreach ($fields as $field => $maxLength) {
    $value = $_POST[$field] ?? '';
    $values[$field] = is_string($value) ? trim($value) : '';
}

$requiredFields = [
    'nom', 'prenom', 'email', 'telephone', 'niveau_etudes', 'filiere',
    'titre_projet', 'type_projet', 'domaines_cles', 'description',
    'budget_estime', 'date_debut', 'duree_semaines', 'besoin_laboratoire', 'statut',
];

$invalid = false;
foreach ($requiredFields as $field) {
    if ($values[$field] === '') {
        $invalid = true;
        break;
    }
}

foreach ($fields as $field => $maxLength) {
    if ($maxLength !== null && preg_match('/\A.{0,' . $maxLength . '}\z/us', $values[$field]) !== 1) {
        $invalid = true;
        break;
    }
}

$dateParts = explode('-', $values['date_debut']);
$validDate = count($dateParts) === 3
    && preg_match('/\A\d{4}-\d{2}-\d{2}\z/', $values['date_debut']) === 1
    && checkdate((int) ($dateParts[1] ?? 0), (int) ($dateParts[2] ?? 0), (int) ($dateParts[0] ?? 0));

$duration = filter_var($values['duree_semaines'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 52]]);
$budget = is_numeric($values['budget_estime']) ? (float) $values['budget_estime'] : -1;
$validStatuses = ['En attente', 'Valide', 'En cours', 'Termine', 'Rejete'];

// Refuse les valeurs absentes ou qui ne respectent pas le format attendu par la base.
if (
    $invalid
    || filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false
    || !$validDate
    || $duration === false
    || !is_finite($budget)
    || $budget < 0
    || $budget > 99999999.99
    || !in_array($values['besoin_laboratoire'], ['Oui', 'Non'], true)
    || !in_array($values['statut'], $validStatuses, true)
) {
    set_flash('danger', 'Vérifiez les champs du formulaire : certaines valeurs sont manquantes ou invalides.');
    header('Location: ../admin.php?edit=' . $id);
    exit;
}

$values['budget_estime'] = $budget;
$values['duree_semaines'] = $duration;

// Les paramètres nommés empêchent l'injection SQL pendant la mise à jour.
try {
    $stmt = Database::getConnection()->prepare("
        UPDATE projets_inscriptions
        SET nom = :nom,
            prenom = :prenom,
            email = :email,
            telephone = :telephone,
            niveau_etudes = :niveau_etudes,
            filiere = :filiere,
            titre_projet = :titre_projet,
            type_projet = :type_projet,
            domaines_cles = :domaines_cles,
            budget_estime = :budget_estime,
            date_debut = :date_debut,
            duree_semaines = :duree_semaines,
            besoin_laboratoire = :besoin_laboratoire,
            description = :description,
            statut = :statut
        WHERE id = :id AND deleted_at IS NULL
    ");
    $values['id'] = $id;
    $stmt->execute($values);

    if ($stmt->rowCount() === 0) {
        $check = Database::getConnection()->prepare('SELECT 1 FROM projets_inscriptions WHERE id = :id AND deleted_at IS NULL');
        $check->execute([':id' => $id]);
        if (!$check->fetchColumn()) {
            set_flash('danger', 'Le projet demandé est introuvable.');
            header('Location: ../admin.php');
            exit;
        }
    }

    set_flash('success', 'Le projet a été modifié avec succès.');
} catch (PDOException $e) {
    error_log('Erreur de modification du projet ' . $id . ' : ' . $e->getMessage());
    set_flash('danger', 'Impossible de modifier le projet pour le moment.');
}

header('Location: ../admin.php');
exit;
