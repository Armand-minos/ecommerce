<?php 
class refcommande {
    private $date;
    public $client;
    public $commande;
    public $produit;
    public $quantite;
    public $prix;
    public $taxe;
    private $modepayment;
    private $pdo; // Pour la connexion à la base de données

    // Constructeur pour initialiser la commande
    public function __construct($client, $commande, $produit, $quantite, $prix, $taxe, $modepayment, $pdo) {
        $this->date = date("Y-m-d H:i:s"); // Date actuelle
        $this->client = $client;
        $this->commande = $commande;
        $this->produit = $produit;
        $this->quantite = $quantite;
        $this->prix = $prix;
        $this->taxe = $taxe;
        $this->modepayment = $modepayment;
        $this->pdo = $pdo; // Initialiser la connexion PDO
    }

    // Méthode pour obtenir la date
    public function getDate() {
        return $this->date;
    }

    // Méthode pour obtenir le mode de paiement
    public function getModePayment() {
        return $this->modepayment;
    }

    // Méthode pour calculer le total de la commande
    public function calculerTotal() {
        $sousTotal = $this->quantite * $this->prix;
        $totalAvecTaxe = $sousTotal + ($sousTotal * $this->taxe / 100);
        return $totalAvecTaxe;
    }

    // Méthode pour afficher les détails de la commande
    public function afficherDetails() {
        echo "Date de la commande: " . $this->getDate() . "<br>";
        echo "Client: " . $this->client . "<br>";
        echo "Commande: " . $this->commande . "<br>";
        echo "Produit: " . $this->produit . "<br>";
        echo "Quantité: " . $this->quantite . "<br>";
        echo "Prix unitaire: " . $this->prix . "<br>";
        echo "Taxe: " . $this->taxe . "%<br>";
        echo "Total: " . $this->calculerTotal() . "<br>";
        echo "Mode de paiement: " . $this->getModePayment() . "<br>";
    }

    // Méthode pour insérer la commande dans la base de données
    public function insererCommande() {
        try {
            $sql = "INSERT INTO commandes (date, client, commande, produit, quantite, prix, taxe, modepayment) 
                    VALUES (:date, :client, :commande, :produit, :quantite, :prix, :taxe, :modepayment)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':date' => $this->getDate(),
                ':client' => $this->client,
                ':commande' => $this->commande,
                ':produit' => $this->produit,
                ':quantite' => $this->quantite,
                ':prix' => $this->prix,
                ':taxe' => $this->taxe,
                ':modepayment' => $this->getModePayment()
            ]);
            echo "Commande insérée avec succès !<br>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de la commande : " . $e->getMessage() . "<br>";
        }
    }
}

// Exemple d'utilisation
try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $commande1 = new refcommande("Jean Dupont", "CMD123", "Produit A",  2, 50, 20, "Carte de crédit", $pdo);
    $commande1->afficherDetails();
    $commande1->insererCommande();
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "<br>";
}
?>