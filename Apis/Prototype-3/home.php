<?php
session_start();
if (isset($_SESSION['email'])) {
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $email = $_SESSION['email'];
} else {
    header('location:index.php');
}

if (isset($_POST["logOUT"])) {
    session_destroy();
    header('location:index.php');
}
require_once('config.php');
require_once('php/gestionStagiaire.php');
$dbGraphique = new GestionStagiaire($pdo);
$countStagiaires = $dbGraphique->showGraphique();

if ($countStagiaires !== false) {
    $cityData = [];

    foreach ($countStagiaires as $row) {
        $city = $row['nom_ville'];
        $internCount = $row['nombre_stagiaires'];
        $cityData[$city] = $internCount;
    }
}

if (isset($_POST["deleteAccount"])) {
    $dbDeleteAccount = new GestionStagiaire($pdo);
    $deleteAccount = $dbDeleteAccount->deleteStagiare($email, $prenom, $nom);
    if ($deleteAccount === TRUE) {
        session_destroy();
        header('location:index.php');
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="list.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Liste des stagiaires</span>
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
                            <span class="d-none d-sm-inline mx-1"><?php echo $nom . ' ' . $prenom; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="stagiaire.php">Profil</a></li>
                            <li>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer mon compte</button>
                            </li>

                            <form action="" method="post">
                                <button type="submit" name="logOUT" class="dropdown-item">Deconnexion</button>
                            </form>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <h3 class="lead" style="margin-bottom: 50px;margin-top:20px;">Statistiques</h3>

                <canvas id="myBarChart" width="550" height="150"></canvas>



            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Supression de compte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="lead">Voulez-vous supprimer votre compte ?</h3>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quitter</button>
                    <form action="" method="post">
                        <button type="submit" name="deleteAccount" class="btn btn-primary">Oui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        var cityData = <?php echo json_encode($cityData); ?>;

        var ctx = document.getElementById('myBarChart').getContext('2d');

        var data = {
            labels: Object.keys(cityData),
            datasets: [{
                label: 'Nombre des stagiaires par ville',
                data: Object.values(cityData),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        var options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>


</body>

</html>