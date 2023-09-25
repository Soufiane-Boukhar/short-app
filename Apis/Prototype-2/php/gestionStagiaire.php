<?php 

class GestionStagiaire {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function checkEmail($email){
        $queryCheckEmail = "SELECT COUNT(*) FROM stagiaire WHERE email = :email";
        $stmtCheckEmail = $this->pdo->prepare($queryCheckEmail);
        $stmtCheckEmail->bindParam(':email', $email);
        $stmtCheckEmail->execute();
        $emailCount = $stmtCheckEmail->fetchColumn();
    
        if ($emailCount > 0) {
            return true;
        }
    }

    public function insertStagiaire(Stagiaire $stagiaire, Ville $ville) {
    
        $queryPersonne = "INSERT INTO personne (nom, prenom) VALUES (:nom, :prenom)";
        $stmtPersonne = $this->pdo->prepare($queryPersonne);
        $stmtPersonne->bindParam(':nom', $stagiaire->getNom());
        $stmtPersonne->bindParam(':prenom', $stagiaire->getPrenom());
        $stmtPersonne->execute();
        $personneId = $this->pdo->lastInsertId();
    
        $queryVille = "INSERT INTO ville (nom_ville, id_personne) VALUES (:nom_ville, :id_personne)";
        $stmtVille = $this->pdo->prepare($queryVille);
        $stmtVille->bindParam(':nom_ville', $ville->getVille());
        $stmtVille->bindParam(':id_personne', $personneId);
        $stmtVille->execute();
    
        $hashed_password = password_hash($stagiaire->getPassword(), PASSWORD_DEFAULT);
        $queryStagiaire = "INSERT INTO stagiaire (id_personne, email, password) VALUES (:id_personne, :email, :password)";
        $stmtStagiaire = $this->pdo->prepare($queryStagiaire);
        $stmtStagiaire->bindParam(':id_personne', $personneId);
        $stmtStagiaire->bindParam(':email', $stagiaire->getEmail());
        $stmtStagiaire->bindParam(':password', $hashed_password);
        $stmtStagiaire->execute();
        return true;
    }
    


    public function showStagiaire(){
        $queryStagiaires = "SELECT p.nom, p.prenom, s.email, v.nom_ville FROM personne p INNER JOIN ville v ON v.id_personne = p.id INNER JOIN stagiaire s ON s.id_personne = p.id";
        $stmtStagiairesList = $this->pdo->prepare($queryStagiaires);
        $stmtStagiairesList->execute();
        $stagiaires = [];
    
        while ($row = $stmtStagiairesList->fetch(PDO::FETCH_ASSOC)) {
            $stagiaire = new Stagiaire($row['nom'],$row['prenom'],$row['email'],'');
            $ville = new Ville($row['nom_ville']);
            $stagiaires[] = [
                'stagiaire' => $stagiaire,
                'ville' => $ville->getVille(),
            ];
        }
    
        return $stagiaires;
    }


 
    
    
    public function showMyInfo($email){
        $queryINfo = "SELECT * FROM stagiaire s INNER JOIN personne p ON s.id_personne = p.id INNER JOIN ville v ON  p.id = v.id_personne WHERE s.email= :email";
        $stmtInfo = $this->pdo->prepare($queryINfo);
        $stmtInfo->bindParam(':email',$email);
        $stmtInfo->execute();
        $info = [];

        while($row = $stmtInfo->fetch(PDO::FETCH_ASSOC)){
            $stagiaire = new Stagiaire($row['nom'],$row['prenom'],$row['email'],'');
            $ville = new Ville($row['nom_ville']);
            $info[] = [
                'stagiaire' => $stagiaire,
                'ville' => $ville->getVille(),
            ];
        }


        return $info;
    }
    


    public function editerStagiaire($nom,$prenom,$email,$ville,$FINDemail){
        $queryPersonne = "UPDATE personne SET nom = :nom , prenom = :prenom WHERE id IN (SELECT id_personne FROM stagiaire WHERE email = :FINDemail)";
        $stmtPersonne = $this->pdo->prepare($queryPersonne);
        $stmtPersonne->bindParam(':nom',$nom);
        $stmtPersonne->bindParam(':prenom',$prenom);
        $stmtPersonne->bindParam(':FINDemail',$FINDemail);
        $stmtPersonne->execute();


        $queryVille = "UPDATE ville SET nom_ville = :ville WHERE id_personne IN (SELECT id_personne FROM stagiaire WHERE email = :FINDemail)";
        $stmtVille = $this->pdo->prepare($queryVille);
        $stmtVille->bindParam(':ville',$ville);
        $stmtVille->bindParam(':FINDemail',$FINDemail);
        $stmtVille->execute();


        $queryStagiaire = "UPDATE stagiaire SET email = :email WHERE email = :FINDemail";
        $stmtStagiaire = $this->pdo->prepare($queryStagiaire);
        $stmtStagiaire->bindParam(':email',$email);
        $stmtStagiaire->bindParam(':FINDemail',$FINDemail);
        $stmtStagiaire->execute();
    }

    public function editePassword($password,$newPassword,$email){
        $queryPass = "SELECT password FROM stagiaire WHERE email= :email";
        $stmtPass = $this->pdo->prepare($queryPass);
        $stmtPass->bindParam(':email',$email);
        $stmtPass->execute();
        $passAnciene = $stmtPass->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password , $passAnciene['password'])){
            $ancienPassHashed = password_hash($newPassword,PASSWORD_DEFAULT);
            $queryChangePass = "UPDATE stagiaire SET password = :passwordNew WHERE email = :email";
            $stmtPassNew = $this->pdo->prepare($queryChangePass);
            $stmtPassNew->bindParam(':passwordNew',$ancienPassHashed);
            $stmtPassNew->bindParam(':email',$email);
            $stmtPassNew->execute();
            return true;
        }else{
            return false;
        }

    }


    public function deleteStagiare($email,$prenom,$nom){

        $queryDeleteVille = "DELETE FROM ville WHERE id_personne IN (SELECT id_personne FROM stagiaire WHERE email = :email)";
        $stmtDeleteVille = $this->pdo->prepare($queryDeleteVille);
        $stmtDeleteVille->bindParam(':email',$email);
        $stmtDeleteVille->execute();

        $queryDeleteStagiare = "DELETE FROM stagiaire WHERE email = :email";
        $stmtDeleteStagiaire = $this->pdo->prepare($queryDeleteStagiare);
        $stmtDeleteStagiaire->bindParam(':email',$email);
        $stmtDeleteStagiaire->execute();

        $queryDeletePersonne = "DELETE FROM personne WHERE nom = :nom AND prenom = :prenom";
        $stmtDeletePersonne = $this->pdo->prepare($queryDeletePersonne);
        $stmtDeletePersonne->bindParam(':nom',$nom);
        $stmtDeletePersonne->bindParam(':prenom',$prenom);
        $stmtDeletePersonne->execute();
        return true;
    }


    public function login($email, $password)
    {
      $sql = $this->pdo->prepare("SELECT * FROM stagiaire s INNER JOIN personne p ON s.id_personne = p.id INNER JOIN ville v ON  p.id = v.id_personne WHERE s.email= :email");
      $sql->bindParam(':email', $email);
      $sql->execute();

      $stagiaire = $sql->fetch(PDO::FETCH_ASSOC);

      if ($stagiaire) {
        if (password_verify($password, $stagiaire['password'])) {
          return $stagiaire;
        }
      }
      return false;
    }

   
}


?>