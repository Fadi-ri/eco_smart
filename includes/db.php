<?php
// Paramètres de connexion MySQL (XAMPP / WampServer)
$host   = 'localhost';
$dbname = 'ecosmart_lab';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,#si error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    // Mode de secours SQLite si MySQL n'est pas démarré
    $pdo = new PDO("sqlite:" . __DIR__ . "/../database.sqlite", null, null, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, #si error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("CREATE TABLE IF NOT EXISTS projets_inscriptions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT, prenom TEXT, email TEXT, telephone TEXT, niveau_etudes TEXT,
        filiere TEXT, titre_projet TEXT, type_projet TEXT, domaines_cles TEXT,
        budget_estime REAL DEFAULT 0, date_debut TEXT, duree_semaines INTEGER DEFAULT 4,
        besoin_laboratoire TEXT DEFAULT 'Non', description TEXT, statut TEXT DEFAULT 'En attente',
        created_at TEXT DEFAULT CURRENT_TIMESTAMP
    )");
}

// Fonction d'accès direct à la base
function getPDO(): PDO {
    global $pdo;
    return $pdo;
}

// Alias de compatibilité
class Database {
    public static function getConnection(): PDO {
        return getPDO();
    }
    public static function isFallbackMode(): bool {
        return false;
    }
}

