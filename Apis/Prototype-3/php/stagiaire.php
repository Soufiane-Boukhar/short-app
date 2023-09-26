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



?>
