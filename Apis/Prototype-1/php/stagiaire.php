<?php 

class Personne{
    protected $nom;
    protected $prenom;


    public function __construct($nom,$prenom){
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }
   
}


class Stagiaire extends Personne{
    private $email;
    private $password;

    public function __construct($nom,$prenom,$email,$password)
    {
        parent::__construct($nom,$prenom);
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

}

class Ville{
    private $nom_ville;

    public function __construct($nom_ville){
        $this->nom_ville = $nom_ville;
    }

    public function getVille(){
        return $this->nom_ville;
    }
}



class GestionStagiaire {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertStagiaire(Stagiaire $stagiaire , Ville $ville) {
        $queryPersonne = "INSERT INTO personne (nom, prenom) VALUES (:nom, :prenom)";
        $stmtPersonne = $this->pdo->prepare($queryPersonne);
        $stmtPersonne->bindParam(':nom', $stagiaire->getNom());
        $stmtPersonne->bindParam(':prenom', $stagiaire->getPrenom());
        $stmtPersonne->execute();
        $personneId = $this->pdo->lastInsertId();
        $queryVille = "INSERT INTO ville (nom_ville, id_personne) VALUES (:nom_ville, :id_personne)";
        $stmtVille = $this->pdo->prepare($queryVille);
        $stmtVille->bindParam(':nom_ville',$ville->getVille());
        $stmtVille->bindParam(':id_personne', $personneId);
        $stmtVille->execute();
        $hashed_password = password_hash($stagiaire->getPassword(),PASSWORD_DEFAULT);
        $queryStagiaire = "INSERT INTO stagiaire (id_personne, email, password) VALUES (:id_personne, :email, :password)";
        $stmtStagiaire = $this->pdo->prepare($queryStagiaire);
        $stmtStagiaire->bindParam(':id_personne', $personneId);
        $stmtStagiaire->bindParam(':email', $stagiaire->getEmail());
        $stmtStagiaire->bindParam(':password', $hashed_password);
        $stmtStagiaire->execute();
       
    }


    public function showStagiaire(){
        $queryStagiaires = "SELECT * FROM `personne` p INNER JOIN ville v ON v.id_personne = p.id INNER JOIN stagiaire s ON s.id_personne = p.id";
        $stmtStagiairesList = $this->pdo->prepare($queryStagiaires);
        $stmtStagiairesList->execute();
        $stagiaires = $stmtStagiairesList->fetchAll(PDO::FETCH_ASSOC);
        return $stagiaires;
    }
    
}


?>
