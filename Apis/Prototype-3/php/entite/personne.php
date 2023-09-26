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
?>