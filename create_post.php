<?php
require_once __DIR__ . '/config.php';
$pdo = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $auteur  = 'Admin'; // In a real app, this would come from session/auth
    $imagePath = null;

    // Check if an image file was uploaded without error
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['image']['tmp_name'];
        $fileName      = $_FILES['image']['name'];
        $fileSize      = $_FILES['image']['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate extension and MIME type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $allowedMimeTypes  = ['image/jpeg', 'image/png', 'image/webp'];
        $fileMimeType      = mime_content_type($fileTmpPath);

        // Limit to 3 MB
        if ($fileSize <= 3 * 1024 * 1024 && in_array($fileExtension, $allowedExtensions, true) && in_array($fileMimeType, $allowedMimeTypes, true)) {
            
            // Create a unique secure filename
            $newFileName = uniqid('post_', true) . '.' . $fileExtension;
            
            // Destination directory on server
            $uploadDir = __DIR__ . '/uploads/posts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . $newFileName;

            // Move uploaded file to destination
            if (move_uploaded_file($fileTmpPath, $destination)) {
                // Relative path to store in database
                $imagePath = 'uploads/posts/' . $newFileName;
            }
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => 'Format invalide ou fichier trop volumineux (max 3 Mo).'
            ];
            header('Location: feed.php');
            exit;
        }
    }

    // Insert into database
    try {
        $stmt = $pdo->prepare("
            INSERT INTO `posts` (`titre`, `contenu`, `auteur`, `image`) 
            VALUES (:titre, :contenu, :auteur, :image)
        ");
        
        $stmt->execute([
            ':titre'   => $titre,
            ':contenu' => $contenu,
            ':auteur'  => $auteur,
            ':image'   => $imagePath
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Publication créée avec succès !'
        ];
    } catch (Exception $e) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'Erreur lors de la création de la publication : ' . $e->getMessage()
        ];
    }

    header('Location: feed.php');
    exit;
} else {
    // If accessed directly via GET, redirect back
    header('Location: feed.php');
    exit;
}
