<?php 
require_once('../application/entite/stagiaire.php');
class ModelStagiaire{
    public function validateDonne($nom,$prenom,$email,$password){
        if(!empty($nom) && !empty($prenom) && !empty($email) && !empty($password)){
            $stagiaire = new Stagiaire($nom,$prenom,$email,$password);
        }
    }
}
?>