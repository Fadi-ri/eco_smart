```php
<?php
session_start();

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
        $erreur = "La vérification du compte sera ajoutée à l'étape suivante.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EcoSmart</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f0f7f1;
        }

        .connexion {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            color: #237447;
            text-align: center;
        }

        .description {
            margin-bottom: 25px;
            color: #666;
            text-align: center;
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #237447;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #195b36;
        }

        .erreur {
            padding: 12px;
            border-radius: 8px;
            background: #fff0f0;
            color: #a32222;
        }
    </style>
</head>
<body>
    <main class="connexion">
        <h1>EcoSmart</h1>
        <p class="description">Connectez-vous à votre espace</p>

        <?php if ($erreur !== ''): ?>
            <p class="erreur" role="alert">
                <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Adresse e-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                autocomplete="email"
                required
            >

            <label for="mot_de_passe">Mot de passe</label>
            <input
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                autocomplete="current-password"
                required
            >

            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>
</html>
```