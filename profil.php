```php
<?php
session_start();

require_once __DIR__ . '/config.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Mon profil - EcoSmart Lab";

require_once __DIR__ . '/includes/hearder.php';
?>

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <div class="card shadow p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle text-primary"
                       style="font-size: 4rem;"></i>

                    <h1 class="h3 mt-3">Mon profil</h1>
                    <p class="text-secondary">
                        Bienvenue sur ton espace personnel EcoSmart Lab.
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nom complet</label>
                    <p class="form-control">
                        <?= htmlspecialchars(
                            $_SESSION['utilisateur_nom'] ?? 'Non renseigné',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Adresse e-mail</label>
                    <p class="form-control">
                        <?= htmlspecialchars(
                            $_SESSION['utilisateur_email'] ?? 'Non renseignée',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>
                </div>

                <div class="d-flex justify-content-between gap-2 mt-3">
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="bi bi-house me-1"></i>
                        Accueil
                    </a>

                    <a href="logout.php" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Se déconnecter
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
```