<?php 
class ProductIdentifier {
    
    private $year;
    private $month;
    private $pdo; // Pour la connexion à la base de données

    public function __construct($pdo)
    {
        $this->year = date('y');
        $this->month = date('m');
        $this->pdo = $pdo; // Initialiser la connexion PDO
    }

    public function generateIdentifier($productType) {
        switch (strtoupper($productType)) {
            case 'SAVON':
                $prefix = 'SA';
                break;
            case 'SAVON LIQUIDE':
                $prefix = 'SAL';
                break;
            case 'SHAMPOING':
                $prefix = 'SHA';
                break;
            default:
                throw new Exception("Type de produit non reconnu.");
        }
        return $prefix . $this->year . '_' . $this->month;
    }

    // Méthode pour insérer l'identifiant de produit dans la base de données
    public function insertProductIdentifier($productType) {
        try {
            $identifier = $this->generateIdentifier($productType);
            $sql = "INSERT INTO product_identifiers (identifier, product_type) VALUES (:identifier, :product_type)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':identifier' => $identifier,
                ':product_type' => $productType
            ]);
            echo "Identifiant de produit inséré avec succès : $identifier<br>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de l'identifiant de produit : " . $e->getMessage() . "<br>";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . "<br>";
        }
    }
}

// Exemple d'utilisation
try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $identifierGenerator = new ProductIdentifier($pdo);

    // Générer et insérer des identifiants de produits
    $identifierGenerator->insertProductIdentifier('savon');    
    $identifierGenerator->insertProductIdentifier('savon liquide');   
    $identifierGenerator->insertProductIdentifier('shampoing'); 
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>