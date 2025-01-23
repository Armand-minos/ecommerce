<?php
class Admin {
    private $db;
    private $username;
    private $password;
    private $isLoggedIn = false;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function setCredentials($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function login() {
        if (empty($this->username) || empty($this->password)) {
            echo "Veuillez entrer un nom d'utilisateur et un mot de passe.";
            return;
        }

        // Préparation de la requête SQL pour récupérer l'utilisateur
        $query = "SELECT password FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Vérification du mot de passe haché
            if (password_verify($this->password, $user['password'])) {
                $this->isLoggedIn = true;
                $this->redirectToDashboard();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Nom d'utilisateur non trouvé.";
        }
    }

    private function redirectToDashboard() {
        if ($this->isLoggedIn) {
            echo "Connexion réussie. Redirection vers le tableau de bord...";
            
        }
    }
}
<form method="POST">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Se connecter</button>
</form>
CREATE DATABASE admin_db;

USE admin_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Ajout d'un utilisateur avec un mot de passe haché
INSERT INTO users (username, password) 
VALUES ('admin', '$2y$10$eY9y5gYjGJ4i8IU0uLbELO8W/KJ3anPqNGl9aPYdHL3R.ZyxhdXsW'); -- password: "password123"
