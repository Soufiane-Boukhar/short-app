<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<?php
$message = '';
require_once('../metier/ModelPersonne.php'); 
require_once('../metier/ModelStagiaire.php'); 
require_once('../metier/ModelVille.php');
require_once('../application/gestion/gestionStagiaire.php');
require_once('../data-base/config.php');

if (isset($_POST['submit'])) {
    try {
        $f_name = $_POST["f_name"];
        $l_name = $_POST["l_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $nom_ville = $_POST["ville"];

        $db = new GestionStagiaire($pdo);

        $stagiaire = new Stagiaire($f_name, $l_name, $email, $password);
        $stagiaireValide = new ModelStagiaire();
        $stagiaireValide->validateDonne($stagiaire->getNom(), $stagiaire->getPrenom(), $stagiaire->getEmail(), $stagiaire->getPassword());

        $ville = new Ville($nom_ville);
        $villeValide = new ModelVille();
        $villeValide->validateDonne($ville->getVille());

        

        $stagiaireFunctions = $db->insertStagiaire($stagiaire, $ville);
        if ($stagiaireFunctions) {
            header("location:home.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>










  <section class="vh-100" style="background-color: #5eb1f7;">
    <div class="container py-2 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="img/photo-1613980790147-f4f449df0dd9.jpeg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-2 p-lg-3 text-black">

                  <form action="" method="post">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                      <span class="h1 fw-bold mb-0">StagiairePlus</span>
                    </div>
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Ajouter un noveau stagiaire</h5>
                    <div class="d-flex">
                      <div class="form-outline mb-4">
                        <input type="text" id="f_name" class="form-control form-control-lg" name="f_name" placeholder="Votre nom"/>
                      </div>
                      <div class="form-outline mb-4" style="margin-left: 10px;">
                        <input type="text" id="l_name" class="form-control form-control-lg" name="l_name" placeholder="Votre prenom"/>
                      </div>
                    </div>

                    <div class="d-flex">

                      <div class="form-outline mb-4">
                        <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="Votre email"/>
                      </div>
                      <div class="form-outline mb-4"  style="margin-left: 10px;">
                        <select class="form-select form-select-lg" aria-label="Default select example" name="ville">
                          <option selected>Choisir la ville</option>
                          <option value="Casablanca">Casablanca</option>
                          <option value="Tanger">Tanger</option>
                          <option value="Rabat">Rabat</option>
                          <option value="Marrakech">Marrakech</option>
                          <option value="Agadir">Agadir</option>
                          <option value="Mohammédia">Mohammédia</option>
                          <option value="Tétouan">Tétouan</option>
                          <option value="Fès">Fès</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="Mot de pass"/>
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Inscription</button>
                    </div>

                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Vous avez un compte ? <a href="index.php"
                      style="color: #393f81;">Connexion</a></p>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>








  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>