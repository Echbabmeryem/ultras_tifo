<?php
// Inclure votre fichier de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tif";

$con = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($con->connect_error) {
    die("La connexion a échoué : " . $con->connect_error);
}

// Fonction pour récupérer le nombre de tifos ajoutés
function getNumberOfTifos($con) {
    $query = "SELECT COUNT(*) AS total_tifos FROM tifos";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    return $row['total_tifos'];
}

?>


        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <style>
        .action-buttons {
            display: inline-block;
        }
        .action-column {
            white-space: nowrap; /* Empêcher le texte de se briser */
            width: 1%; /* Force la colonne à se réduire à la taille minimale */
        }
        .welcome-banner {
            background-color: #7fc3c0; /* Couleur de fond */
            color: #fff; /* Couleur du texte */
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .welcome-banner h2 {
            margin: 0;
        }

        .line {
            border-top: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            margin-bottom: 20px;
            width: 200px; /* Largeur des cartes */
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 16px;
            padding-bottom: 10px;
        }

        .card-text {
            line-height: 1.5;
        }

        .btn {
            float: right;
        }
    </style>










    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">UltrasTifo</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-house"></i>
                        <span>Accueil</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="fas fa-shield-alt"></i>
                        <span>Gérer Tifo</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="ajout.php" class="sidebar-link">Ajouter un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Chercher un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Liste des Tifos</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Imprimer la liste des Tifos</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#nouveau-menu" aria-expanded="false" aria-controls="nouveau-menu">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Planifier Tifo</span>
                    </a>
                    <ul id="nouveau-menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Définir une tâche</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Modifier une tâche</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">PDF des tâches</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#contact-menu" aria-expanded="false" aria-controls="contact-menu">
                        <i class="fas fa-comments"></i>
                        <span>Contacter</span>
                    </a>
                    <ul id="contact-menu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Contacter Leader</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="messageEmail.php" class="sidebar-link">Contacter Membre</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-cogs"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
                <!-- Ajouter le label pour basculer entre les modes -->
                <a href="#" class="sidebar-link" id="mode-toggle">
                    <i class="fas fa-moon"></i>
                    <span>Mode Sombre</span>
                </a>
            </div>
        </aside>

        <div class="content">
            <header class="navbar">
                <div class="navbar-profile">
                    <a href="#" class="profile-link">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </header>





























            <div class="container-fluid">
    <div class="welcome-banner">
        <h2>Bienvenue</h2>
    </div>
    <div class="text-start mb-4"> <!-- Aligner le texte "Accueil" à gauche -->
        <h3>Accueil</h3>
    </div>
    <div class="line"></div>
    <div class="row row-cols-auto">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tifo Totals</h5>
                    <p class="card-text"><?php echo getNumberOfTifos($con); ?></p>
                    <a href="#" class="btn btn-primary">See more</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Leader Total</h5>
                    <p class="card-text"> </p>
                    <a href="#" class="btn btn-primary">See more</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main p-3">
            
            </div>






    </div>
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
