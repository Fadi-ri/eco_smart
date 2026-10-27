<?php
/**
 * Tableau de bord CRUD - EcoSmart Lab
 */
$pageTitle = 'Tableau de bord CRUD';
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();
$projects = [];
$editProject = null;
$loadError = false;
$showTrash = ($_GET['view'] ?? '') === 'trash';

// Si un identifiant est fourni dans l'URL, charge le projet à modifier.
try {
    if (isset($_GET['edit']) && !$showTrash) {
        $editId = filter_var($_GET['edit'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        if ($editId === false) {
            set_flash('danger', 'Identifiant de projet invalide.');
        } else {
            $editStmt = $pdo->prepare('SELECT * FROM projets_inscriptions WHERE id = :id AND deleted_at IS NULL');
            $editStmt->execute([':id' => $editId]);
            $editProject = $editStmt->fetch();

            if (!$editProject) {
                set_flash('danger', 'Le projet demandé est introuvable.');
            }
        }
    }

    // Charge les projets actifs ou archivés selon la vue sélectionnée.
    $stmt = $pdo->query("
        SELECT id, titre_projet, nom, prenom, filiere, statut, created_at, deleted_at
        FROM projets_inscriptions
        WHERE deleted_at IS " . ($showTrash ? 'NOT NULL' : 'NULL') . "
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1 class="fw-bold mb-1">Tableau de bord des projets</h1>
                <p class="text-muted mb-0">Consultez et gérez les projets enregistrés sur la plateforme.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="admin.php" class="btn <?= $showTrash ? 'btn-outline-primary' : 'btn-primary' ?>">
                    <i class="bi bi-grid me-1"></i> Projets actifs
                </a>
                <a href="admin.php?view=trash" class="btn <?= $showTrash ? 'btn-primary' : 'btn-outline-secondary' ?>">
                    <i class="bi bi-trash me-1"></i> Corbeille
                </a>
                <?php if (!$showTrash): ?>
                    <a href="inscription.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Ajouter un projet
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Le formulaire de modification ne s'affiche que lorsqu'un projet est sélectionné. -->
    <?php if ($editProject && !$showTrash): ?>
        <div class="card-custom p-3 p-md-4 mb-4">
            <h2 class="h5 fw-bold mb-3">Modifier le projet #<?= (int) $editProject['id'] ?></h2>
            <form action="actions/update.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int) $editProject['id'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input class="form-control" id="nom" name="nom" maxlength="100" required value="<?= e($editProject['nom']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input class="form-control" id="prenom" name="prenom" maxlength="100" required value="<?= e($editProject['prenom']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="150" required value="<?= e($editProject['email']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input class="form-control" id="telephone" name="telephone" maxlength="30" required value="<?= e($editProject['telephone']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="niveau_etudes" class="form-label">Niveau d’études</label>
                        <input class="form-control" id="niveau_etudes" name="niveau_etudes" maxlength="50" required value="<?= e($editProject['niveau_etudes']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="filiere" class="form-label">Filière</label>
                        <input class="form-control" id="filiere" name="filiere" maxlength="150" required value="<?= e($editProject['filiere']) ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="titre_projet" class="form-label">Titre du projet</label>
                        <input class="form-control" id="titre_projet" name="titre_projet" maxlength="200" required value="<?= e($editProject['titre_projet']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="type_projet" class="form-label">Type de projet</label>
                        <input class="form-control" id="type_projet" name="type_projet" maxlength="80" required value="<?= e($editProject['type_projet']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="domaines_cles" class="form-label">Domaines clés</label>
                        <textarea class="form-control" id="domaines_cles" name="domaines_cles" rows="2" required><?= e($editProject['domaines_cles']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" required><?= e($editProject['description']) ?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label for="budget_estime" class="form-label">Budget estimé (€)</label>
                        <input type="number" class="form-control" id="budget_estime" name="budget_estime" min="0" max="99999999.99" step="0.01" required value="<?= e($editProject['budget_estime']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut" required value="<?= e($editProject['date_debut']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="duree_semaines" class="form-label">Durée (semaines)</label>
                        <input type="number" class="form-control" id="duree_semaines" name="duree_semaines" min="1" max="52" required value="<?= e($editProject['duree_semaines']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="besoin_laboratoire" class="form-label">Besoin labo</label>
                        <select class="form-select" id="besoin_laboratoire" name="besoin_laboratoire">
                            <option value="Oui" <?= $editProject['besoin_laboratoire'] === 'Oui' ? 'selected' : '' ?>>Oui</option>
                            <option value="Non" <?= $editProject['besoin_laboratoire'] === 'Non' ? 'selected' : '' ?>>Non</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut" required>
                            <?php foreach (['En attente', 'Valide', 'En cours', 'Termine', 'Rejete'] as $status): ?>
                                <option value="<?= e($status) ?>" <?= $editProject['statut'] === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="admin.php" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Affiche une erreur, un état vide ou la liste des projets selon le résultat de la requête. -->
    <div class="card-custom p-3 p-md-4">
        <?php if ($loadError): ?>
            <p class="text-muted mb-0">La liste <?= $showTrash ? 'de la corbeille' : 'des projets' ?> est indisponible.</p>
        <?php elseif (empty($projects)): ?>
            <p class="text-muted mb-0"><?= $showTrash ? 'La corbeille est vide.' : 'Aucun projet n’a encore été enregistré.' ?></p>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0"><?= $showTrash ? 'Projets dans la corbeille' : 'Projets enregistrés' ?></h2>
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
                            <th scope="col"><?= $showTrash ? 'Date de suppression' : 'Date d’ajout' ?></th>
                            <th scope="col">Actions</th>
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
                                <td><?= format_date($showTrash ? $project['deleted_at'] : $project['created_at']) ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <?php if ($showTrash): ?>
                                            <form action="actions/restore.php" method="POST">
                                                <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-success" aria-label="Restaurer <?= e($project['titre_projet']) ?>" title="Restaurer">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                            <form action="actions/permanent_delete.php" method="POST" onsubmit="return confirm('Supprimer définitivement ce projet ? Cette action est irréversible.');">
                                                <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Supprimer définitivement <?= e($project['titre_projet']) ?>" title="Supprimer définitivement">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="admin.php?edit=<?= (int) $project['id'] ?>" class="btn btn-sm btn-outline-primary" aria-label="Modifier <?= e($project['titre_projet']) ?>">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="actions/delete.php" method="POST" onsubmit="return confirm('Déplacer ce projet dans la corbeille ?');">
                                                <input type="hidden" name="csrf_token" value="<?= e(generate_csrf_token()) ?>">
                                                <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Archiver <?= e($project['titre_projet']) ?>" title="Déplacer dans la corbeille">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>