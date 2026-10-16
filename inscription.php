<?php
session_start();

require_once __DIR__ . "/config.php";

$pageTitle = "Inscription - EcoSmart Lab";
$erreur = "";
$succes = "";
$nom = "";
$prenom = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["nom"] ?? "");
    $prenom = trim($_POST["prenom"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $mot_de_passe = $_POST["mot_de_passe"] ?? "";

    if ($nom === "" || $prenom === "" || $email === "" || $mot_de_passe === "") {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse e-mail invalide.";
    } elseif (strlen($mot_de_passe) < 8) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        try {
            $verification = $pdo->prepare(
                "SELECT id FROM users WHERE email = ?"
            );
            $verification->execute([$email]);

            if ($verification->fetch()) {
                $erreur = "Cette adresse e-mail possède déjà un compte.";
            } else {
                $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $requete = $pdo->prepare(
                    "INSERT INTO users (nom, prenom, email, mot_de_passe)
                     VALUES (?, ?, ?, ?)"
                );
                $requete->execute([$nom, $prenom, $email, $hash]);

                $succes = "Compte créé avec succès !";
                $nom = "";
                $prenom = "";
                $email = "";
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la création du compte.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | EcoSmart Lab</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #0b2239;
            color: #f5f8fc;
        }

        .carte {
            width: 100%;
            max-width: 430px;
            padding: 35px;
            border: 1px solid #12b9d6;
            border-radius: 18px;
            background: #122c46;
            box-shadow: 0 10px 35px #0004;
        }

        h1 { text-align: center; margin-bottom: 8px; }

        .logo {
            text-align: center;
            color: #12c5df;
            font-size: 25px;
            font-weight: bold;
        }

        .description {
            text-align: center;
            color: #bdcada;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin: 16px 0 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #49647d;
            border-radius: 8px;
            background: #0b2239;
            color: white;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #1473f9;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover { background: #12b9d6; }

        .message { margin-top: 15px; text-align: center; }
        .erreur { color: #ff9292; }
        .succes { color: #52e0b0; }

        a { color: #12c5df; }
        .bas { text-align: center; margin-top: 22px; }
    </style>
</head>
<body>
    <main class="carte">
        <div class="logo">EcoSmart Lab</div>
        <h1>Créer un compte</h1>
        <p class="description">Rejoins notre plateforme collaborative.</p>

        <?php if ($erreur !== ""): ?>
            <p class="message erreur">
                <?= htmlspecialchars($erreur, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <?php if ($succes !== ""): ?>
            <p class="message succes">
                <?= htmlspecialchars($succes, ENT_QUOTES, "UTF-8") ?>
                <br><a href="login.php">Se connecter</a>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text" maxlength="100" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="prenom">Prénom</label>
            <input id="prenom" name="prenom" type="text" maxlength="100" value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email">Adresse e-mail</label>
            <input id="email" name="email" type="email" maxlength="190" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input id="mot_de_passe" name="mot_de_passe" type="password" minlength="8" required>

            <button type="submit">Créer mon compte</button>
        </form>

        <p class="bas">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
        </p>
    </main>
</body>
</html>
