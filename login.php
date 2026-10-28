<?php
session_start();

require_once __DIR__ . '/config.php';

$pageTitle = "Connexion - EcoSmart Lab";
$erreur = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Veuillez saisir une adresse e-mail valide.";
    } elseif ($mot_de_passe === '') {
        $erreur = "Veuillez saisir votre mot de passe.";
    } else {
        try {
            $pdo = Database::getConnection();

            $requete = $pdo->prepare(
                'SELECT id, nom, prenom, email, mot_de_passe
                 FROM users
                 WHERE email = ?'
            );

            $requete->execute([$email]);
            $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

            if (
                $utilisateur &&
                password_verify(
                    $mot_de_passe,
                    $utilisateur['mot_de_passe']
                )
            ) {
                session_regenerate_id(true);

                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur_nom'] = $utilisateur['nom'];
                $_SESSION['utilisateur_prenom'] = $utilisateur['prenom'];
                $_SESSION['utilisateur_email'] = $utilisateur['email'];

                header('Location: index.php');
                exit;
            } else {
                $erreur = "Adresse e-mail ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $erreur = "Impossible de vérifier le compte pour le moment.";
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow p-4">
                <div class="text-center mb-4">
                    <h1 class="h3">Connexion</h1>
                    <p class="text-secondary">
                        Bienvenue sur EcoSmart Lab
                    </p>
                </div>

                <?php if ($erreur !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars(
                            $erreur,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Adresse e-mail
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars(
                                $email,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                            placeholder="exemple@email.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">
                            Mot de passe
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="mot_de_passe"
                            name="mot_de_passe"
                            placeholder="Votre mot de passe"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Se connecter
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Pas encore de compte ?
                    <a href="inscription.php">Créer un compte</a>
                </p>
            </div>

        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
git stach login.php