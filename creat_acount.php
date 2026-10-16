<?php
session_start();

require_once __DIR__ . '/config.php';

$pageTitle = "Creer un compte - EcoSmart Lab";
$erreur = '';
$succes = '';
$nom = '';
$prenom = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if ($nom === '' || $prenom === '' || $email === '' || $mot_de_passe === '') {
        $erreur = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse e-mail invalide.';
    } elseif (strlen($mot_de_passe) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caracteres.';
    } else {
        try {
            $pdo = Database::getConnection();

            $verification = $pdo->prepare(
                'SELECT id FROM users WHERE email = ?'
            );
            $verification->execute([$email]);

            if ($verification->fetch()) {
                $erreur = 'Cette adresse e-mail possede deja un compte.';
            } else {
                $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $requete = $pdo->prepare(
                    'INSERT INTO users (nom, prenom, email, mot_de_passe)
                     VALUES (?, ?, ?, ?)'
                );
                $requete->execute([$nom, $prenom, $email, $hash]);

                $succes = 'Compte cree avec succes !';
            }
        } catch (PDOException $e) {
            $erreur = 'Erreur lors de la creation du compte.';
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
                    <h1 class="h3">Creer un compte</h1>
                    <p class="text-secondary">
                        Rejoins notre plateforme collaborative.
                    </p>
                </div>

                <?php if ($erreur !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <?php if ($succes !== ''): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($succes, ENT_QUOTES, 'UTF-8') ?>
                        <br><a href="login.php">Se connecter</a>
                    </div>
                <?php endif; ?>

                <form method="POST" action="creat_acount.php">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nom"
                            name="nom"
                            maxlength="100"
                            value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prenom</label>
                        <input
                            type="text"
                            class="form-control"
                            id="prenom"
                            name="prenom"
                            maxlength="100"
                            value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            maxlength="190"
                            value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                            placeholder="exemple@email.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input
                            type="password"
                            class="form-control"
                            id="mot_de_passe"
                            name="mot_de_passe"
                            minlength="8"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Creer mon compte
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Deja inscrit ?
                    <a href="login.php">Se connecter</a>
                </p>
            </div>

        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
