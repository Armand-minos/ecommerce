<?php 
class Facture {
    public $date;
    public $client;
    public $numcommande;
    public $articles; // Un tableau d'articles
    public $quantite; // Un tableau de quantités
    public $prix; // Un tableau de prix
    public $taxe;
    private $modepayment;
    private $modelivraison;
    private $pdo; // Pour la connexion à la base de données

    // Constructeur pour initialiser la facture
    public function __construct($client, $numcommande, $articles, $quantite, $prix, $taxe, $modepayment, $modelivraison, $pdo) {
        $this->date = date("Y-m-d H:i:s"); // Date actuelle
        $this->client = $client;
        $this->numcommande = $numcommande;
        $this->articles = $articles;
        $this->quantite = $quantite;
        $this->prix = $prix;
        $this->taxe = $taxe;
        $this->modepayment = $modepayment;
        $this->modelivraison = $modelivraison;
        $this->pdo = $pdo; // Initialiser la connexion PDO
    }

    // Méthode pour calculer le total de la facture
    public function calculerTotal() {
        $sousTotal = 0;
        for ($i = 0; $i < count($this->articles); $i++) {
            $sousTotal += $this->quantite[$i] * $this->prix[$i];
        }
        $totalAvecTaxe = $sousTotal + ($sousTotal * $this->taxe / 100);
        return $totalAvecTaxe;
    }

    // Méthode pour afficher les détails de la facture
    public function afficherDetails() {
        echo "Date de la facture: " . $this->date . "<br>";
        echo "Client: " . $this->client . "<br>";
        echo "Numéro de commande: " . $this->numcommande . "<br>";
        echo "Articles: <br>";
        for ($i = 0; $i < count($this->articles); $i++) {
            echo "- " . $this->articles[$i] . ": " . $this->quantite[$i] . " x " . $this->prix[$i] . " €<br>";
        }
        echo "Taxe: " . $this->taxe . "%<br>";
        echo "Total: " . $this->calculerTotal() . " €<br>";
        echo "Mode de paiement: " . $this->modepayment . "<br>";
        echo "Mode de livraison: " . $this->modelivraison . "<br>";
    }

    // Méthode pour insérer la facture dans la base de données
    public function insererFacture() {
        try {
            $sql = "INSERT INTO factures (date, client, numcommande, articles, quantite, prix, taxe, modepayment, modelivraison) 
                    VALUES (:date, :client, :numcommande, :articles, :quantite, :prix, :taxe, :modepayment, :modelivraison)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':date' => $this->date,
                ':client' => $this->client,
                ':numcommande' => $this->numcommande,
                ':articles' => json_encode($this->articles), // Convertir le tableau en JSON
                ':quantite' => json_encode($this->quantite), // Convertir le tableau en JSON
                ':prix' => json_encode($this->prix), // Convertir le tableau en JSON
                ':taxe' => $this->taxe,
                ':modepayment' => $this->modepayment,
                ':modelivraison' => $this->modelivraison
            ]);
            echo "Facture insérée avec succès !<br>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion de la facture : " . $e->getMessage() . "<br>";
        }
    }
}

// Exemple