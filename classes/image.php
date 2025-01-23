<?php

class ProductImage
{
    private $uploadDir;
    private $pdo;

    public function __construct($pdo, $uploadDir = "uploads/")
    {
        $this->pdo = $pdo;
        $this->uploadDir = rtrim($uploadDir, '/') . '/';

        // Vérifie si le dossier existe, sinon le crée
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    // Méthode pour télécharger une image
    public function uploadImage($file, $productId)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors du téléchargement de l'image.");
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception("Extension de fichier non autorisée.");
        }

        $fileName = $productId . '_' . uniqid() . '.' . $fileExtension;
        $filePath = $this->uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Impossible de déplacer l'image téléchargée.");
        }

        // Sauvegarde des informations dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO product_images (product_id, file_name) VALUES (:product_id, :file_name)");
        $stmt->execute([
            ':product_id' => $productId,
            ':file_name' => $fileName
        ]);

        return $fileName;
    }

    // Méthode pour récupérer les images d'un produit
    public function getImagesByProductId($productId)
    {
        $stmt = $this->pdo->prepare("SELECT file_name FROM product_images WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Méthode pour supprimer une image
    public function deleteImage($fileName)
    {
        $filePath = $this->uploadDir . $fileName;

        // Supprime l'image du répertoire
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Supprime l'entrée de la base de données
        $stmt = $this->pdo->prepare("DELETE FROM product_images WHERE file_name = :file_name");
        $stmt->execute([':file_name' => $fileName]);

        return true;
    }
}

?>
<?php

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=ecommerce';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$pdo = new PDO($dsn, $username, $password, $options);

// Création de l'instance ProductImage
$imageManager = new ProductImage($pdo, "product_images/");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
        // Téléchargement d'une image
        $productId = 123; // ID du produit
        $fileName = $imageManager->uploadImage($_FILES['image'], $productId);
        echo "Image téléchargée avec succès : $fileName";
    }

    // Affiche les images associées à un produit
    $productId = 123;
    $images = $imageManager->getImagesByProductId($productId);
    echo "Images pour le produit $productId : " . implode(', ', $images);

    // Suppression d'une image
    if (isset($_POST['delete_image'])) {
        $imageManager->deleteImage($_POST['delete_image']);
        echo "Image supprimée avec succès.";
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<!-- Formulaires HTML -->
<form method="POST" enctype="multipart/form-data">
    <label for="image">Télécharger une image :</label>
    <input type="file" name="image" id="image" required>
    <button type="submit">Télécharger</button>
</form>

<form method="POST">
    <label for="delete_image">Nom de l'image à supprimer :</label>
    <input type="text" name="delete_image" id="delete_image">
    <button type="submit">Supprimer</button>
</form>

<!-- sql -->
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
