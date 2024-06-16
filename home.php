<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: sign.php');
    exit();
}


?>

<?php
include 'connexion.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .action-buttons {
            display: inline-block;
        }
        .action-column {
            white-space: nowrap; 
            width: 1%;
        }
        .welcome-banner-container {
    border-radius: 10px;
    padding: 10px;
    margin-bottom: -10px; 
}
        .welcome-banner {
            background-color: #9abbfc; 
            color: #fff; 
            padding: 10px;
            text-align: left;
            margin-bottom: 20px;

        }

        .welcome-banner h2 {
            margin: 0;
        }

        .line {
    border-top: 1px solid #145f9c; 
    height: 1px;
    margin-bottom: 20px;
}
.linee {
    border-top: 3px solid rgba(0, 0, 0, 0.2);
    height: 1px;
    margin-bottom: 20px;
}      .card {
    border-top: 
            3px solid rgba(0, 0, 0, 0.2); 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            margin-bottom: 20px;
            width: 200px; 
            margin-left: 20px;
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
        .background-section {
    background-color: var(--background-light); /* Ajoutez la couleur de fond que vous souhaitez */
    padding: 20px; /* Ajoutez un espace intérieur pour l'esthétique */
}

        /* style.css ou dans la balise <style> de votre fichier HTML */

html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}


.content {
    flex: 1;
    overflow-y: auto;
}
.custom-icon {
  margin-left: 40px; /* Décalage vers la droite */
  margin-top: 5px;   /* Décalage vers le bas */
}
.custom {
  margin-left: 60px; /* Décalage vers la droite */
  margin-top: 5px;   /* Décalage vers le bas */
}


    </style>
</head>
<body>
    
<div class="wrapper r d-flex vh-100">
        <aside id="sidebar" class="vh-100">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="sidebar-logo">
                    <h1 class="ultras-font" style="margin-bottom: 0px; font-family: Algerian; font-size: 25px; color: #fff;">UltrasTifo</h1> </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="home.php" class="sidebar-link">
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
                            <a href="ajouter.php" class="sidebar-link">Ajouter un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="chercher.php" class="sidebar-link">Chercher un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="innnn.php" class="sidebar-link">Liste des Tifos</a>
                            
                        </li>
                        <li class="sidebar-item">
                            <a href="print.php" class="sidebar-link">Imprimer la liste des Tifos</a>
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
                            <a href="defTache.php.php" class="sidebar-link">Définir une tâche</a>
                        </li>
                       
                        <li class="sidebar-item">
                            <a href="pdf.php" class="sidebar-link">PDF des tâches</a>
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
                            <a href="messageEmail.php" class="sidebar-link">Contacter Leader</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="" class="sidebar-link">Contacter Membre</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="parametre.php" class="sidebar-link">
                        <i class="fas fa-cogs"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">   
                <a href="#" class="sidebar-link" id="mode-toggle">
                    <i class="fas fa-moon"></i>
                    <span>Mode Sombre</span>
                </a>
                
            </div>
        </aside>

        <div class="content ">
        <header class="navbar">
            <div class="navbar-left">
                    <span class="leader-text">𝙴𝚜𝚙𝚊𝚌𝚎 𝙻𝚎𝚊𝚍𝚎𝚛</span>
                </div>
                <div class="navbar-profile">

                        <a  class=" profile-link  " href="logout.php"   >
                        Deconnexion<i class="bi bi-box-arrow-in-up-right"></i>
                     </a>     
                </div>
</header>
            <div class="welcome-banner-container">      
    <div class="welcome-banner">
        <h2>Bienvenue <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    </div></div>
    <div class="text-start mb-4"> 
         <h3 class="mb-0">Accueil</h3>
    </div>
    <div class="line"></div>
    <div class="row row-cols-auto">
    <div class="col">
        <div class="card border-warning mb-3" style="max-width: 18rem;">
            <div class="card-header">
                 Tifo Totals<i class="bi bi-file-image custom"></i>

            </div>
            <div class="card-body">
                <p class="card-text"><?php echo getNumberOfTifos($con); ?></p>

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">
                 Leader Totals<i class="bi bi-person-check custom-icon"></i>
            </div>
            <div class="card-body text-primary">
                <p class="card-text"><?php echo getNumberOfleader($con); ?></p>
            </div>
        </div>
    </div>
    <div class="main p-3"></div>
</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>