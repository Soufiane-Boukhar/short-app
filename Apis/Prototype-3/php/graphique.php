<?php

class Graphique{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function show()
    {
        $queryGraphique = "SELECT ville.nom_ville, COUNT(stagiaire.id) AS nombre_stagiaires FROM ville INNER JOIN personne ON personne.id = ville.id_personne INNER JOIN stagiaire ON stagiaire.id_personne = personne.id GROUP BY ville.nom_ville";
        $stmtGraphique = $this->pdo->prepare($queryGraphique);
        $stmtGraphique->execute(); 

        $result = $stmtGraphique->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            return $result; 
        } else {
            return false; 
        }
    }
}

?>


