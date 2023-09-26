<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <?php

  require('config.php');
  require_once('php/gestion/gestionStagiaire.php');
  $message = "";

 

  if (isset($_POST["signin"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $logInStagiaire = new GestionStagiaire($pdo);
    $stagiaire = $logInStagiaire->login($email, $password);

    if ($stagiaire) {
      session_start();
      $_SESSION['email'] = $email;
      $_SESSION['nom'] = $stagiaire['nom'];
      $_SESSION['prenom'] = $stagiaire['prenom'];
      $_SESSION['nom_ville'] = $stagiaire['nom_ville'];


      header("Location: home.php");
    } else {
      $message = "L'adresse e-mail ou le mot de passe est incorrect";
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
                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connecter à votre profil</h5>
                    <p class="text-danger"><?php echo $message;?></p>
                    <div class="form-outline mb-4">
                      <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="Votre email" />
                    </div>
                    <div class="form-outline mb-4">
                      <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="Votre mot de pass" />
                    </div>
                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="signin">Connexion</button>
                    </div>
                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Vous n'avez pas de compte ? <a href="register.php" style="color: #393f81;">Inscription ici</a></p>
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