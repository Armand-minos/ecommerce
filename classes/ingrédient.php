<?php 
class Ingredient {
    private $id;
    private $nom;
    private $quantite;
    private $unite;
    private $oilvegetal;
    private $naturelconservator;
    private $BioOilvegetal;
    private $extraitvegetal;
    private $pdo; 

    public function __construct($id, $nom, $quantite, $unite, $oilvegetal = false, $naturelconservator = false, $BioOilvegetal = false, $extraitvegetal = false, $pdo = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->quantite = $quantite;
        $this->unite = $unite;
        $this->oilvegetal = $oilvegetal;
        $this->naturelconservator = $naturelconservator;
        $this->BioOilvegetal = $BioOilvegetal;
        $this->extraitvegetal = $extraitvegetal;
        $this->pdo = $pdo; 
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getQuantite() {
        return $this->quantite;
    }

    public function getUnite() {
        return $this->unite;
    }

    public function getOilvegetal() {
        return $this->oilvegetal;
    }

    public function getNaturelconservator() {
        return $this->naturelconservator;
    }

    public function getBiooilvegetal() {
        return $this->BioOilvegetal;
    }

    public function getExtraitvegetal() {
        return $this->extraitvegetal;
    }

    // Méthode pour afficher les détails de l'ingrédient
    public function afficherDetails() {
        echo "id: " . $this->getId() . "<br>";
        echo "Nom: " . $this->getNom() . "<br>";
        echo "Quantité: " . $this->getQuantite() . " " . $this->getUnite() . "<br>";
        echo "Huile Végétale: " . ($this->getOilvegetal() ? "Oui" : "Non") . "<br>";
        echo "Conservateur Naturel: " . ($this->getNaturelconservator() ? "Oui" : "Non") . "<br>";
        echo "Huile Végétale Bio: " . ($this->getBiooilvegetal() ? "Oui" : "Non") . "<br>";
        echo "Extrait Végétal: " . ($this->getExtraitvegetal() ? "Oui" : "Non") . "<br>";
    }

    // Méthode pour insérer l'ingrédient dans la base de données
    public function insererIngredient() {
        if ($this->pdo === null) {
            throw new Exception("La connexion à la base de données n'est pas établie.");
        }

        try {
            $sql = "INSERT INTO ingredients (id, nom, quantite, unite, oilvegetal, naturelconservator, BioOilvegetal, extraitvegetal) 
                    VALUES (:id, :nom, :quantite, :unite, :oilvegetal, :naturelconservator, :BioOilvegetal, :extraitvegetal)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':nom' => $this->nom,
                ':quantite' => $this->quantite,
                ':unite' => $this->unite,
                ':oilvegetal' => $this->oilvegetal,
                ':naturelconservator' => $this->naturelconservator,
                ':BioOilvegetal' => $this->BioOilvegetal,
                ':extraitvegetal' => $this->extraitvegetal
            ]);
            echo "Ingrédient inséré avec succès : " . $this->nom . "<br>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de l'ingrédient : " . $e->getMessage() . "<br>";
        }
    }
}

// Exemple d'utilisation
try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_d onnees', 'votre_utilisateur', 'votre_mot_de_passe');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ingredient1 = new Ingredient("Huile d'olive", 100, "ml", true, false, true, false, $pdo);
    $ingredient2 = new Ingredient("Extrait de vanille", 50, "ml", false, true, false, true, $pdo);
    $ingredient3 = new Ingredient("Sucre", 200, "g", false, false, false, false, $pdo);

    // Affichage des détails des ingrédients
    $ingredient1->afficherDetails();
    echo "<br>";
    $ingredient2->afficherDetails();
    echo "<br>";
    $ingredient3->afficherDetails();
    echo "<br>";

    // Insertion des ingrédients dans la base de données
    $ingredient1->insererIngredient();
    $ingredient2->insererIngredient();
    $ingredient3->insererIngredient();
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>