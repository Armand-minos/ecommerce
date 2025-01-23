<?php 
class Client {
    private $nom; 
    private $prenom;
    private $adresse;
    private $city;
    private $codepostal;
    private $telephone;
    private $mail;
    
    // Constructeur pour initialiser les propriétés
    public function __construct($nom, $prenom, $adresse, $city, $codepostal, $telephone, $mail)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->city = $city;
        $this->codepostal = $codepostal;
        $this->telephone = $telephone;
        $this->mail = $mail;
    }

    // Méthodes d'accès (getters)
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCodePostal() {
        return $this->codepostal;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getMail() {
        return $this->mail;
    }

    // Méthode pour afficher les détails du client
    public function afficherDetails() {
        echo "Nom: " . $this->getNom() . "\n";
        echo "Prénom: " . $this->getPrenom() . "\n";
        echo "Adresse: " . $this->getAdresse() . "\n";
        echo "Ville: " . $this->getCity() . "\n";
        echo "Code Postal: " . $this->getCodePostal() . "\n";
        echo "Téléphone: " . $this->getTelephone() . "\n";
        echo "Email: " . $this->getMail() . "\n";
    }
}

// Exemple d'utilisation
$client1 = new Client("Dupont", "Jean", "123 Rue de Paris", "Paris", "75001", "0123456789", "jean.dupont@example.com");
$client1->afficherDetails();
?>