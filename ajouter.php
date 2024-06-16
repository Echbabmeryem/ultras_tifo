<?php
session_start();
include 'connexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = mysqli_real_escape_string($con, $_POST["description"]);
    $date_execution = mysqli_real_escape_string($con, $_POST["date"]);
    $temp_debut = mysqli_real_escape_string($con, $_POST["tempsD"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $pwd = mysqli_real_escape_string($con, $_POST['pwd']);

    
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image = $_FILES["image"]["tmp_name"];
        $imageContent = addslashes(file_get_contents($image));
$query = "SELECT MAX(id_tifo) AS max_id FROM tifos";
$result = $con->query($query);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];
$new_id = $max_id + 1;

$sql = "INSERT INTO tifos (id_tifo, description, date_execution, image, temp_debut, email, motpasse) 
        VALUES ('$new_id', '$description', '$date_execution', '$imageContent', '$temp_debut', '$email', '$pwd')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['message'] = "Nouveau tifo ajouté avec succès";
        } else {
            $_SESSION['message'] ='Erreur : " . $sql . "<br>" . $con->error . "';
        }
        
    } else {
        $_SESSION['message'] ='Erreur : Aucune image téléchargée.';
    }
}?>        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UltrasTifo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head><style>
    .fixed-textarea {
        width: 300%; /* Largeur à 100% du conteneur parent */
        height: 60px; /* Hauteur fixe, ajustez selon vos besoins */
        max-width: 1090px; /* Largeur maximale, ajustez selon vos besoins */
    }
</style>
<body>
    
    <div class="wrapper">
        <aside id="sidebar" class= "vh-100" >
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="sidebar-logo">
                <h1 class="ultras-font" style="margin-bottom: 0px; font-family: Algerian; font-size: 25px; color: #fff;">UltrasTifo</h1> </div>
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
                            <a href="defTache.php" class="sidebar-link">Définir une tâche</a>
                        </li>
                        
                        <li class="sidebar-item">
                            <a href="pdf.php" class="sidebar-link" target="_blank">PDF des tâches</a>
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
                            <a href="message/index.php" class="sidebar-link">Contacter Leader</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="messageEmail.php" class="sidebar-link">Contacter Membre</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="parametre.php" class="sidebar-link">
                        <i class="fas fa-cogs"></i>
                        <span id="parametre">Paramètres</span>

                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                
                <!-- Ajouter le label pour basculer entre les modes -->
                <a href="#" class="sidebar-link" id="mode-toggle">
                    <i class="fas fa-moon"></i>
                    <span>Mode Sombre</span>
                </a>
            </div>
        </aside>

        <div class="content">
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
      <div class="container background-white mt-4">
        <div class="row">
            <div class="col-md-12">
            <?php include('message.php'); ?>

            <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h4 >Ajouter un Tifo</h4>
                <a href="innnn.php"  class="btn btn-danger btn-sm" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;">Retour</a>
            </div>
            <div class="card-body">
            <div class="center-form">

            <form class="was-validated form-container" action="" method="post" enctype="multipart/form-data" novalidate>
            <div class="row mb-6  mt-6">
                    <div class="col mb-6 mt-6"> 
                    <label class="form-label">Date d'exécution</label>
                    <input class="form-control" type="date" name="date" required>
                </div>
                <div class="col mb-6 mt-6"> 
                    <label for="email" class="form-label">Email d'Ultras</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                </div>
                </div>

                <div class="row mb-6  mt-6">
                    <div class="col mb-6 mt-6">             
                    <label class="form-label">Temps début</label>
                    <input type="time" class="form-control" name="tempsD" placeholder="entrer le temps de début du tifo" required>
                </div>
                
                <div class="col mb-6 mt-6">             
                <label class="form-label">Mot de passe Tifo</label>
<div class="input-group">
    <input class="form-control password" type="password" name="pwd" placeholder="entrer le mot de passe" required>
    <span class="input-group-text">
        <i class="uil uil-eye-slash showHidePw" style="cursor: pointer;"></i>
    </span>
</div>


</div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image de Tifo</label>
                <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control fixed-textarea" id="description" name="description" rows="4" cols="50" required></textarea>
            </div>
            <div class="text-center">
            <input class="btn btn-sm btn-primary" type="submit" name="ajouter" value="Ajouter" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;">  </div>
        </form>
    
            </div>
            </div>
        </div>
      </div>    </div>
    
      </div>
    </div>
    
</body>
</html>
<script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script>
            document.getElementById("parametre").addEventListener("click", function() {
    window.location.href = "parametre.php";
});

        </script>
        <script>
    document.querySelector('.showHidePw').addEventListener('click', function() {
        const passwordField = document.querySelector('.password');
        const eyeIcon = document.querySelector('.showHidePw');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('uil-eye-slash');
            eyeIcon.classList.add('uil-eye');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('uil-eye');
            eyeIcon.classList.add('uil-eye-slash');
        }
    });
</script>