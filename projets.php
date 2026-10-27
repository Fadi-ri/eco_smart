<?php
/**
 * Catalogue des Projets & Innovations
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
$pageTitle = "Catalogue des Projets & Innovations";
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();

// Recuperation de tous les projets
$projects = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `projets_inscriptions` WHERE deleted_at IS NULL ORDER BY id DESC");
        $projects = $stmt->fetchAll();
    } catch (Exception $e) {}
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
    <!-- En-tete de la page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Showcase & Portfolio</span>
            <h1 class="fw-bold m-0">Projets & Innovations Ingenieurs</h1>
            <p class="text-muted m-0">Decouvrez lensemble des initiatives technologiques portees par les etudiants et enseignants de lECAM-EPMI.</p>
        </div>



            <div class="add_post">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addChoiceModal">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>

            <!-- Modal de choix : Post ou Projet -->
            <div class="modal fade" id="addChoiceModal" tabindex="-1" aria-labelledby="addChoiceModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addChoiceModalLabel">Que souhaitez-vous ajouter ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body d-flex gap-3 justify-content-center py-4">
                            <button type="button" class="btn btn-outline-primary btn-lg flex-fill py-4 js-open-sub-modal" data-bs-dismiss="modal" data-target="#customPostSubmissionModal">
                                <i class="bi bi-file-earmark-post d-block fs-1 mb-2"></i>
                                Ajouter un Post
                            </button>
                            <a href="inscription.php" class="btn btn-outline-success btn-lg flex-fill py-4">
                                <i class="bi bi-rocket-takeoff d-block fs-1 mb-2"></i>
                                Ajouter un Projet
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade custom_post_submission" id="customPostSubmissionModal" tabindex="-1" aria-labelledby="customPostSubmissionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customPostSubmissionModalLabel">Nouveau Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <form action="create_post.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre du post</label>
                                    <input type="text" name="titre" id="titre" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="contenu" class="form-label">Contenu</label>
                                    <textarea name="contenu" id="contenu" class="form-control" rows="4" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image illustrative</label>
                                    <!-- input de type file acceptant les images -->
                                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg, image/webp">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Publier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </div>

    <!-- Barre doutils de Recherche & Filtres Dynamiques (Interactivite JS) -->
    <div class="card-custom p-3 mb-4">
        <div class="row g-3 align-items-center">
            <!-- Recherche textuelle -->
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="projectSearchInput" class="form-control border-start-0" placeholder="Rechercher par titre, etudiant, technologie..." aria-label="Recherche">
                </div>
            </div>

            <!-- Filtre par Filiere -->
            <div class="col-md-4">
                <select id="filiereFilter" class="form-select">
                    <option value="ALL">Toutes les filieres</option>
                    <option value="Energie & Developpement Durable">Energie & Developpement Durable</option>
                    <option value="Systemes dInformation & IA">Systemes dInformation & IA</option>
                    <option value="Robotique & Systemes Embarques">Robotique & Systemes Embarques</option>
                    <option value="Mobilite Electrique & Smart Cities">Mobilite Electrique & Smart Cities</option>
                    <option value="Genie Industriel & 4.0">Genie Industriel & 4.0</option>
                </select>
            </div>

            <!-- Filtre par Statut -->
            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="ALL">Tous les statuts</option>
                    <option value="Valide">Valide</option>
                    <option value="En cours">En cours</option>
                    <option value="En attente">En attente</option>
                    <option value="Termine">Termine</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Grille des Projets -->
    <div class="row g-4" id="projectsContainer">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="col-lg-4 col-md-6 project-card-item" 
                     data-filiere="<?= e($project['filiere']) ?>" 
                     data-statut="<?= e($project['statut']) ?>"
                     data-search="<?= strtolower(e($project['titre_projet'] . ' ' . $project['nom'] . ' ' . $project['prenom'] . ' ' . $project['domaines_cles'] . ' ' . $project['filiere'])) ?>">
                    
                    <div class="card-custom p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary small fw-semibold">
                                <i class="bi bi-tag-fill me-1"></i> <?= e($project['type_projet']) ?>
                            </span>
                            <?= get_status_badge($project['statut']) ?>
                        </div>

                        <h5 class="fw-bold mt-2 mb-2 text-truncate-2" title="<?= e($project['titre_projet']) ?>">
                            <?= e($project['titre_projet']) ?>
                        </h5>

                        <div class="small text-muted mb-2">
                            <i class="bi bi-mortarboard me-1"></i> <?= e($project['filiere']) ?> (<?= e($project['niveau_etudes']) ?>)
                        </div>

                        <p class="text-muted small flex-grow-1 line-clamp-3">
                            <?= e($project['description']) ?>
                        </p>

                        <!-- Domaines Cles -->
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            <?php 
                            $tags = explode(',', $project['domaines_cles']);
                            foreach (array_slice($tags, 0, 3) as $tag): 
                                if (trim($tag)):
                            ?>
                                <span class="badge bg-secondary-subtle text-secondary small"><?= e(trim($tag)) ?></span>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>

                        <div class="border-top pt-3 mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                                <span><i class="bi bi-person-fill me-1"></i> <?= e($project['prenom']) ?> <?= e($project['nom']) ?></span>
                                <span class="fw-bold text-success"><?= format_currency($project['budget_estime']) ?></span>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 js-view-project-modal" 
                                        data-title="<?= e($project['titre_projet']) ?>"
                                        data-author="<?= e($project['prenom'] . ' ' . $project['nom']) ?>"
                                        data-email="<?= e($project['email']) ?>"
                                        data-phone="<?= e($project['telephone']) ?>"
                                        data-filiere="<?= e($project['filiere']) ?>"
                                        data-niveau="<?= e($project['niveau_etudes']) ?>"
                                        data-type="<?= e($project['type_projet']) ?>"
                                        data-domaines="<?= e($project['domaines_cles']) ?>"
                                        data-budget="<?= format_currency($project['budget_estime']) ?>"
                                        data-date="<?= format_date($project['date_debut']) ?>"
                                        data-duree="<?= e($project['duree_semaines']) ?> semaines"
                                        data-labo="<?= e($project['besoin_laboratoire']) ?>"
                                        data-statut="<?= e($project['statut']) ?>"
                                        data-desc="<?= e($project['description']) ?>">
                                    <i class="bi bi-eye me-1"></i> Voir Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-folder2-open display-4 text-muted"></i>
                <p class="text-muted mt-3">Aucun projet trouve.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Message aucun resultat lors du filtrage JS -->
    <div id="noResultsMessage" class="text-center py-5 d-none">
        <i class="bi bi-search display-5 text-muted"></i>
        <h5 class="fw-bold mt-3">Aucun projet ne correspond a vos criteres</h5>
        <p class="text-muted">Essayez de modifier vos termes de recherche ou reinitialisez les filtres.</p>
        <button id="btnResetFilters" class="btn btn-outline-secondary btn-sm">Reinitialiser les filtres</button>
    </div>
</div>

<!-- Modal Details du Projet -->
<div class="modal fade" id="projectDetailsModal" tabindex="-1" aria-labelledby="projectModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="projectModalTitle">Details du Projet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Porteur de Projet</small>
                        <strong id="modalAuthor" class="fs-6">-</strong>
                        <div class="small text-muted" id="modalContact">-</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Filiere & Promotion</small>
                        <strong id="modalFiliere" class="fs-6">-</strong>
                    </div>
                </div>

                <div class="row g-3 mb-3 p-3 bg-light rounded-3 border">
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Type de Projet</small>
                        <span id="modalType" class="fw-semibold">-</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Budget Estime</small>
                        <span id="modalBudget" class="fw-bold text-success">-</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Duree / Debut</small>
                        <span id="modalDates" class="fw-semibold">-</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Besoin Acces Labo</small>
                        <span id="modalLabo" class="fw-semibold">-</span>
                    </div>
                    <div class="col-sm-8">
                        <small class="text-muted d-block">Domaines Cles</small>
                        <span id="modalDomaines" class="badge bg-secondary-subtle text-secondary">-</span>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold text-primary">Description Complete & Objectifs :</h6>
                    <p id="modalDesc" class="text-muted small lh-lg mb-0">-</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    // Enchainement : modal de choix -> modal de formulaire (post ou projet)
    const addChoiceModalEl = document.getElementById('addChoiceModal');
    document.querySelectorAll('.js-open-sub-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetEl = document.querySelector(btn.dataset.target);
            addChoiceModalEl.addEventListener('hidden.bs.modal', function openTarget() {
                bootstrap.Modal.getOrCreateInstance(targetEl).show();
                addChoiceModalEl.removeEventListener('hidden.bs.modal', openTarget);
            });
        });
    });

    const searchInput = document.getElementById('projectSearchInput');
    const filiereFilter = document.getElementById('filiereFilter');
    const statusFilter = document.getElementById('statusFilter');
    const projectCards = document.querySelectorAll('.project-card-item');
    const noResults = document.getElementById('noResultsMessage');
    const btnReset = document.getElementById('btnResetFilters');

    function applyFilters() {
        const query = searchInput.value.toLowerCase().trim();
        const selectedFiliere = filiereFilter.value;
        const selectedStatus = statusFilter.value;
        let visibleCount = 0;

        projectCards.forEach(card => {
            const cardFiliere = card.getAttribute('data-filiere');
            const cardStatus = card.getAttribute('data-statut');
            const searchIndex = card.getAttribute('data-search');

            const matchesQuery = query === '' || searchIndex.includes(query);
            const matchesFiliere = selectedFiliere === 'ALL' || cardFiliere === selectedFiliere;
            const matchesStatus = selectedStatus === 'ALL' || cardStatus === selectedStatus;

            if (matchesQuery && matchesFiliere && matchesStatus) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    searchInput?.addEventListener('input', applyFilters);
    filiereFilter?.addEventListener('change', applyFilters);
    statusFilter?.addEventListener('change', applyFilters);

    btnReset?.addEventListener('click', () => {
        searchInput.value = '';
        filiereFilter.value = 'ALL';
        statusFilter.value = 'ALL';
        applyFilters();
    });

    // Gestion de la modal de details
    const projectDetailsModalEl = document.getElementById('projectDetailsModal');
    const detailsModal = projectDetailsModalEl ? new bootstrap.Modal(projectDetailsModalEl) : null;
    document.querySelectorAll('.js-view-project-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('projectModalTitle').textContent = btn.dataset.title;
            document.getElementById('modalAuthor').textContent = btn.dataset.author;
            document.getElementById('modalContact').textContent = `${btn.dataset.email} | ${btn.dataset.phone}`;
            document.getElementById('modalFiliere').textContent = `${btn.dataset.filiere} (${btn.dataset.niveau})`;
            document.getElementById('modalType').textContent = btn.dataset.type;
            document.getElementById('modalBudget').textContent = btn.dataset.budget;
            document.getElementById('modalDates').textContent = `${btn.dataset.date} (${btn.dataset.duree})`;
            document.getElementById('modalLabo').textContent = btn.dataset.labo === 'Oui' ? 'Oui (Bancs de test / FabLab)' : 'Non requis';
            document.getElementById('modalDomaines').textContent = btn.dataset.domaines;
            document.getElementById('modalDesc').textContent = btn.dataset.desc;

            detailsModal?.show();
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
