<?php 

require_once('stagiaire.php');

class GestionStagiaire {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertStagiaire(Stagiaire $stagiaire) {
       
        $hashed_password = password_hash($stagiaire->getPassword(),PASSWORD_DEFAULT);
        $queryStagiaire = "INSERT INTO stagiaire (nom,prenom, email, password) VALUES (:nom,:prenom, :email, :password)";
        $stmtStagiaire = $this->pdo->prepare($queryStagiaire);
        $stmtStagiaire->bindParam(':nom', $stagiaire->getNom());
        $stmtStagiaire->bindParam(':prenom', $stagiaire->getPrenom());
        $stmtStagiaire->bindParam(':email', $stagiaire->getEmail());
        $stmtStagiaire->bindParam(':password', $hashed_password);
        $stmtStagiaire->execute();
       
    }


    public function showStagiaire(){
        $queryStagiaires = "SELECT * FROM `stagiaire`";
        $stmtStagiairesList = $this->pdo->prepare($queryStagiaires);
        $stmtStagiairesList->execute();
        $stagiaires = $stmtStagiairesList->fetchAll(PDO::FETCH_ASSOC);
        return $stagiaires;
    }
    
}






?>