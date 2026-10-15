<?php
/**
 * Traitement de la Soumission de Projet
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
require_once __DIR__ . '/../config.php';
$pdo = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../inscription.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    set_flash('danger', 'Jeton de securite invalide, merci de reessayer.');
    header('Location: ../inscription.php');
    exit;
}

$nom                = trim($_POST['nom'] ?? '');
$prenom             = trim($_POST['prenom'] ?? '');
$email              = trim($_POST['email'] ?? '');
$telephone          = trim($_POST['telephone'] ?? '');
$niveau_etudes      = trim($_POST['niveau_etudes'] ?? '');
$filiere            = trim($_POST['filiere'] ?? '');
$titre_projet       = trim($_POST['titre_projet'] ?? '');
$type_projet        = trim($_POST['type_projet'] ?? '');
$domaines_cles      = implode(', ', array_map('trim', $_POST['domaines_cles'] ?? []));
$budget_estime      = (float) ($_POST['budget_estime'] ?? 0);
$date_debut         = trim($_POST['date_debut'] ?? '');
$duree_semaines     = (int) ($_POST['duree_semaines'] ?? 0);
$besoin_laboratoire = ($_POST['besoin_laboratoire'] ?? 'Non') === 'Oui' ? 'Oui' : 'Non';
$description        = trim($_POST['description'] ?? '');
$conditions         = isset($_POST['conditions']);

$requiredFields = [
    $nom, $prenom, $email, $telephone, $niveau_etudes, $filiere,
    $titre_projet, $type_projet, $domaines_cles, $date_debut, $description,
];

if (in_array('', $requiredFields, true) || $duree_semaines < 1 || !$conditions) {
    set_flash('danger', 'Merci de remplir tous les champs obligatoires et daccepter le reglement.');
    header('Location: ../inscription.php');
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO `projets_inscriptions`
            (`nom`, `prenom`, `email`, `telephone`, `niveau_etudes`, `filiere`, `titre_projet`, `type_projet`, `domaines_cles`, `budget_estime`, `date_debut`, `duree_semaines`, `besoin_laboratoire`, `description`)
        VALUES
            (:nom, :prenom, :email, :telephone, :niveau_etudes, :filiere, :titre_projet, :type_projet, :domaines_cles, :budget_estime, :date_debut, :duree_semaines, :besoin_laboratoire, :description)
    ");

    $stmt->execute([
        ':nom'                => $nom,
        ':prenom'             => $prenom,
        ':email'              => $email,
        ':telephone'          => $telephone,
        ':niveau_etudes'      => $niveau_etudes,
        ':filiere'            => $filiere,
        ':titre_projet'       => $titre_projet,
        ':type_projet'        => $type_projet,
        ':domaines_cles'      => $domaines_cles,
        ':budget_estime'      => $budget_estime,
        ':date_debut'         => $date_debut,
        ':duree_semaines'     => $duree_semaines,
        ':besoin_laboratoire' => $besoin_laboratoire,
        ':description'        => $description,
    ]);

    set_flash('success', 'Projet depose avec succes !');
} catch (Exception $e) {
    set_flash('danger', 'Erreur lors du depot du projet : ' . $e->getMessage());
    header('Location: ../inscription.php');
    exit;
}

header('Location: ../projets.php');
exit;
