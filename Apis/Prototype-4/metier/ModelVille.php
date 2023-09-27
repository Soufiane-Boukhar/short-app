<?php 
require_once('../application/entite/ville.php');
class ModelVille{
    public function validateDonne($ville){
        if(!empty($ville)){
            $ville = new Ville($ville);
        }
    }
}
?>