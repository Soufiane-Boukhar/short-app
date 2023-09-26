<?php
session_start();
if ($_SESSION["email"] == '') {
    header("location:index.php");
}

if (isset($_POST['logOUT'])) {
    session_destroy();
    header("location:index.php");
}
require_once('config.php');
require_once('php/gestion/gestionStagiaire.php');
if (isset($_POST['update'])) {
    $message = "";
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $ville = $_POST['ville'];
    $FINDemail = $_POST["FINDemail"];
    $stagiaireFunctions = new GestionStagiaire($pdo);

    $editerInfoStagiaire = $stagiaireFunctions->editerStagiaire($nom, $prenom, $email, $ville, $FINDemail);

    if ($editerInfoStagiaire) {
        $message = "";
    } else {
        $message = "Votre profil a été modifié avec succès";
    }
}


if (isset($_POST["changePassword"])) {
    $anciennePss = $_POST["ancienPass"];
    $newPss = $_POST["newPass"];
    $email = $_SESSION['email'];
    $messagePassword = "";

    $dbPass = new GestionStagiaire($pdo);
    $changePassword = $dbPass->editePassword($anciennePss, $newPss, $email);

    if ($changePassword === TRUE) {
        $message = "Votre mot de passe a été modifié avec succès";
    } else {
        $messagePassword = "Ancienne mot de passe est incorrect";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center p-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">StagiairePlus</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 p-2 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="home.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Skills</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Contact</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION['nom']; ?>
                                <?php echo $_SESSION['prenom']; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form action="" method="post">
                                <button type="submit" name="logOUT" class="dropdown-item">Deconnexion</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col p-4">
                <h3 class="lead">Modifier mes informations</h3>
                <div style="margin-top: 50px;">
                    <form action="" method="post">

                        <?php
                        require_once('config.php');
                        require_once('php/entite/stagiaire.php');
                        

                        if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];

                            $dbInfo = new GestionStagiaire($pdo);
                            $infoStagiaire = $dbInfo->showMyInfo($email);

                            if (!empty($infoStagiaire)) {
                                $data = $infoStagiaire[0]['stagiaire'];
                                $ville = $infoStagiaire[0]['ville'];

                        ?>
                                <div class="form-group mb-3">
                                    <label for="f_name">Nom</label>
                                    <input type="text" class="form-control form-control-lg" name="nom" id="f_name" aria-describedby="emailHelp" value="<?php echo $data->getNom(); ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="l_name">Prenom</label>
                                    <input type="text" class="form-control form-control-lg" name="prenom" id="l_name" aria-describedby="emailHelp" value="<?php echo $data->getPrenom(); ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-lg" name="email" id="email" aria-describedby="emailHelp" value="<?php echo $data->getEmail(); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="ville">Ville</label>
                                    <select class="form-select form-select-lg" id="ville" name="ville">
                                        <option value="<?php echo $ville; ?>"><?php echo $ville; ?></option>
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
                                <input type="hidden" name="FINDemail" value="<?php echo $data->getEmail(); ?>">

                                <button type="submit" name="update" class="btn btn-primary mt-3">Editer</button>
                                <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Changer mot de passe
                                </button>
                        <?php
                            } else {
                                echo 'No information found for the logged-in user.';
                            }
                        }
                        ?>



                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Changement le mot de passe</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="password">Ancienne mot de passe</label>
                            <input type="password" class="form-control form-control-lg" name="ancienPass" id="password" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group mb-3">
                            <label for="newPassword">Noveau mot de passe</label>
                            <input type="password" class="form-control form-control-lg" name="newPass" id="newPassword" aria-describedby="emailHelp">
                        </div>

                        <button type="submit" name="changePassword" class="btn btn-primary mt-3">Changer</button>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>