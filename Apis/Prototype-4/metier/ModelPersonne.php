<?php
require_once('../application/entite/personne.php');
class ModelPersonneValidation {
    public function validateDonne($nom,$prenom){
        if(!empty($nom) && !empty($prenom)){
            $personne = new Personne($nom, $prenom);
        }
    }
}
?>
