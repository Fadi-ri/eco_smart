<?php
/**
 * Tableau de bord CRUD - EcoSmart Lab
 */
$pageTitle = 'Tableau de bord CRUD';
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();
$projects = [];
$loadError = false;

try {
    $stmt = $pdo->query("
        SELECT id, titre_projet, nom, prenom, filiere, statut, created_at
        FROM projets_inscriptions
        ORDER BY id DESC
    ");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Erreur de lecture des projets dans admin.php : ' . $e->getMessage());
    $loadError = true;
    set_flash('danger', 'Impossible de charger les projets pour le moment.');
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
    <div class="mb-4">
        <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Administration</span>
        <h1 class="fw-bold mb-1">Tableau de bord des projets</h1>
        <p class="text-muted mb-0">Consultez les projets enregistrés sur la plateforme.</p>
    </div>

    <div class="card-custom p-3 p-md-4">
        <?php if ($loadError): ?>
            <p class="text-muted mb-0">La liste des projets est indisponible.</p>
        <?php elseif (empty($projects)): ?>
            <p class="text-muted mb-0">Aucun projet n’a encore été enregistré.</p>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Projets enregistrés</h2>
                <span class="badge bg-secondary-subtle text-secondary">
                    <?= count($projects) ?> projet<?= count($projects) > 1 ? 's' : '' ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Projet</th>
                            <th scope="col">Étudiant</th>
                            <th scope="col">Filière</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Date d’ajout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= (int) $project['id'] ?></td>
                                <th scope="row"><?= e($project['titre_projet']) ?></th>
                                <td><?= e($project['prenom'] . ' ' . $project['nom']) ?></td>
                                <td><?= e($project['filiere']) ?></td>
                                <td><?= get_status_badge($project['statut']) ?></td>
                                <td><?= format_date($project['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>