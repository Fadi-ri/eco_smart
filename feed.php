<?php
/**
 * Fil d'Actualite
 * EcoSmart Lab - ECAM-EPMI 1AE
 */
$pageTitle = "Fil d'Actualite";
require_once __DIR__ . '/config.php';

$pdo = Database::getConnection();

// Recuperation de tous les posts
$posts = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM `posts` ORDER BY date_publication DESC");
        $posts = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log('feed.php: failed to load posts: ' . $e->getMessage());
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
    <!-- En-tete de la page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="custom-subhead">
            <span class="badge bg-primary-subtle text-primary fw-semibold mb-2">Actualites</span>
            <h1 class="fw-bold m-0">Feed</h1>
            <p class="text-muted m-0">Suivez les dernieres publications et annonces de la communaute EcoSmart Lab.</p>
        </div>

        <div class="add_post">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addChoiceModal">
                <i class="bi bi-plus-circle"></i>
            </button>
        </div>
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

    <!-- Modal Nouveau Post -->
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

    <!-- Fil des publications -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="feed-post-card p-4 mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="brand-icon"><i class="bi bi-person-fill"></i></div>
                            <div>
                                <div class="fw-bold"><?= e($post['auteur']) ?></div>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($post['date_publication'])) ?></small>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-2"><?= e($post['titre']) ?></h5>

                        <?php if (!empty($post['image'])): ?>
                            <img src="<?= e($post['image']) ?>" class="img-fluid rounded-3 mb-3" alt="<?= e($post['titre']) ?>">
                        <?php endif; ?>

                        <p class="text-muted mb-0"><?= nl2br(e($post['contenu'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text display-4 text-muted"></i>
                    <p class="text-muted mt-3">Aucune publication pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Enchainement : modal de choix -> modal de formulaire
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
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
