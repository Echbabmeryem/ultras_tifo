<?php session_start();
?>
<?php

include 'connexion.php';

if (isset($_REQUEST['voir'])) {
    $req = "SELECT * FROM tifos WHERE id_tifo={$_REQUEST['id']}";
    $res = mysqli_query($con, $req);
    $row = mysqli_fetch_assoc($res);
}
?>

<?php

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pwd = $_POST['motdpasse'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $tempD = $_POST['tempD'];

    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['new_image']['tmp_name']);
    } else {
        $image = base64_decode($_POST['current_image']);
    }

    $reqq = "UPDATE tifos SET image=?, email=?, motpasse=?, description=?, date_execution=?, temp_debut=? WHERE id_tifo=?";
    $stmt = $con->prepare($reqq);
    $stmt->bind_param("ssssssi", $image, $email, $pwd, $desc, $date, $tempD, $id);

    if ($stmt->execute()) {
        $_SESSION['message']="tifo modifiée avec succès";
        
    } else {
        $_SESSION['message']="Erreur lors de la modification de la ligne";
    
    }
    // Redirection vers la même page avec l'ID du tifo mis à jour
    

}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tifo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
    .btn-warning{
        background-color: #142e61e8;/* Custom background color */
    color: #ffffff; /* Custom text color */
    border: 2px solid #142e61e8; /* Custom border color */
    border-radius: 5px; /* Rounded corners */

    }
     .img-thumbnail {
            max-width: 110px; 
            max-height: 60px; 
            object-fit: cover;/
        }
        .fixed-textarea {
        width: 359%; 
        height: 60px; 
        max-width: 1080px; 
    }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar"  class=" vh-100">
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
                            <a href="defTache.php" class="sidebar-link">Définir une tâche</a>
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
                
                <a  class="sidebar-link" id="mode-toggle">
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

<div class="container background-white mt-3">
<div class="row">
    <div class="col-md-12">
    <?php include('message.php'); ?>
        <div class="card min-vh-99 max-vh-46">
            <div class="card-header d-flex justify-content-between">
                <h4 >Modifier Tifo</h4>
                <a href="innnn.php"  class="btn btn-danger btn-sm" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;">Retour</a>
           </div>
            <div class="card-body">
                <form class="row " action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="current_image" value="<?php echo isset($_POST['current_image']) ? $_POST['current_image'] : (isset($row['image']) ? base64_encode($row['image']) : ''); ?>">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : (isset($row['id_tifo']) ? $row['id_tifo'] : ''); ?>">
                    <div class="row mb-6  mt-6">
                    <div class="col mb-6 mt-6"> 
                        <label for="new_image" class="form-label ">Nouvelle image</label>
                        <input type="file" id="new_image" accept="image/*" class="form-control" name="new_image">
                    </div>
                    <div class="col-md-6 mt-6">
                        <label for="current_image" class="form-label ">Image actuelle</label>
                        <img src="data:image/jpeg;base64,<?php echo isset($_POST['current_image']) ? $_POST['current_image'] : (isset($row['image']) ? base64_encode($row['image']) : ''); ?>" class="form-control img-thumbnail" /><br />
                    </div>
                    
                    </div>

                    <div class="row mb-6  mt-6">
                        <div class="col-md-6">
                            <label for="email" class="form-label  ">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : (isset($row['email']) ? $row['email'] : ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label ">Password</label>
                            <input type="password" class="form-control" id="password" name="motdpasse" value="<?php echo isset($_POST['motdpasse']) ? $_POST['motdpasse'] : (isset($row['motpasse']) ? $row['motpasse'] : ''); ?>">
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-6">
                        <label for="tempD" class="form-label ">Heure de début du tifo</label>
                        <input type="time" class="form-control" value="<?php echo isset($_POST['tempD']) ? $_POST['tempD'] : (isset($row['temp_debut']) ? $row['temp_debut'] : ''); ?>" name="tempD">
                    </div>
                        <div class="col-md-6">                       
                             <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" value="<?php echo isset($_POST['date']) ? $_POST['date'] : (isset($row['date_execution']) ? $row['date_execution'] : ''); ?>" name="date">
                    </div>

    </div>
                    <div class="mb-6">
                        <label for="description" class="form-label ">Description</label>
                        <textarea class="form-control fixed-textarea" id="description" name="description" rows="4" cols="50"><?php echo isset($_POST['description']) ? $_POST['description'] : (isset($row['description']) ? $row['description'] : ''); ?></textarea>
                    </div>

                    <div class="mb-6 mt-2">
                        <div class="mb-3 text-center d-flex align-items-center justify-content-center">
<button type="submit"    class="btn btn-danger btn-sm" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;"name="update">Modifier</button>
                     </div>      

                     </form>
                     </div >
            </div>
        </div>
    </div>
</div>
</div></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        document.getElementById("parametre").addEventListener("click", function() {
    window.location.href = "parametre.php";
});

    </script>
</body>

</html>