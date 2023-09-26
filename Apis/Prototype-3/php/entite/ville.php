<?php 

class Ville{
    private $nom_ville;

    public function __construct($nom_ville){
        $this->nom_ville = $nom_ville;
    }

    public function getVille(){
        return $this->nom_ville;
    }
}

?>