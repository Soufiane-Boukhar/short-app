<?php
require_once('php/entite/personne.php');

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


?>
