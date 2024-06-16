<?php
session_start();
$currentEmail = $_SESSION['email'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ultras";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify_profile'])) {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];

    if ($newEmail != $currentEmail) {
        if (strpos($newEmail, '@gmail.com') === false) {
            $emailError = "L'email doit être un email @gmail.com.";
        } else {
            $checkEmailQuery = "SELECT * FROM leader WHERE email='$newEmail'";
            $checkEmailResult = $conn->query($checkEmailQuery);
            
            if ($checkEmailResult->num_rows > 0) {
                $emailError = "L'e-mail que vous essayez d'utiliser est déjà associé à un autre compte.";
            } else {
                $sql = "UPDATE leader SET name='$newName', email='$newEmail' WHERE email='$currentEmail'";
                
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message']="Informations mises à jour avec succès.";
                    $_SESSION['email'] = $newEmail;
                } else {
                    $_SESSION['message']= "Erreur lors de la mise à jour des informations: " . $conn->error;
                }
            }
        }
    } else {
        $sql = "UPDATE leader SET name='$newName' WHERE email='$currentEmail'";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message']="Informations mises à jour avec succès.";
        } else {
            $_SESSION['message']= "Erreur lors de la mise à jour des informations: " . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify_password'])) {
    $oldPassword = $_POST['Oldpassword'];
    $newPassword = $_POST['Newpassword'];
    $confirmPassword = $_POST['password'];
    
    $checkPasswordQuery = "SELECT * FROM leader WHERE email='$currentEmail'";
    $checkPasswordResult = $conn->query($checkPasswordQuery);

    if ($checkPasswordResult->num_rows > 0) {
        $row = $checkPasswordResult->fetch_assoc();
        if (password_verify($oldPassword, $row['password'])) {
            if (strlen($newPassword) < 4) {
                $confirmPasswordError = "Le nouveau mot de passe doit contenir au moins 4 caractères.";
            } else {
                if ($newPassword !== $confirmPassword) {
                    $confirmPasswordError = "Les nouveaux mots de passe ne correspondent pas.";
                } else {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    
                    // Mettre à jour le mot de passe dans la base de données
                    $updatePasswordQuery = "UPDATE leader SET password='$hashedPassword' WHERE email='$currentEmail'";
                    if ($conn->query($updatePasswordQuery) === TRUE) {
                        $_SESSION['message']="Mot de passe mis à jour avec succès.";
                    } else {
                        $_SESSION['message']="Erreur lors de la mise à jour du mot de passe: " . $conn->error;
                    }
                }
            }
        } else {
            $oldPasswordError = "L'ancien mot de passe est incorrect.";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification du Profil</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            text-align: center; /* Centrer tout le contenu */
            justify-content: center;
            align-items: center;
        }
        h2 {
            text-align: center; /* Centrer le titre */
            margin-top: -20px; /* Ajustez cette valeur pour déplacer vers le haut */
            margin-bottom: -20px; /* Ajouter un espace en dessous du titre */
        }
        .form-section {
            width: 800px;
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            align-items: center;
            justify-content: center;

        }
        .form-section .text {
            margin-right: 20px;
            min-width: 200px;
            margin-top: -20px; /* Ajustez cette valeur pour déplacer vers le haut */
        }
        .form-container {
            flex: 1;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            margin-top: -15px; 
        }
        .input-group-text {
            font-size: 20px; /* Ajustez la taille du logo */
           }
        .form-group input {
            height: 37px; /* Contrôle la hauteur du premier formulaire */
            width: calc(100% - 22px);
            padding: 3px;
            border: 1px solid #ccc;
            border-radius: 1px;
        }
        .i{  
            border: 1px solid #ccc;
            border-radius: 1px;
        }
        .submit-btn-container {
          display: flex;
         justify-content: center;
        }
        .submit-btn {
            padding: 5px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-top: -10px; /* Ajustez cette valeur pour déplacer vers le haut */
        }
        .submit-btn:hover {
            background-color: #142e61e8;/* Custom background color */
        }
        .submit-btn{
            background-color: #142e61e8;/* Custom background color */
        }
        .separator {
            width:800px;
            margin: 20px 0;
            text-align: center;
            border-bottom: 2px solid #ccc;
            line-height: 1em;
            margin-top: -5px; /* Ajustez cette valeur pour déplacer vers le haut */
        }
        .separator span {
            background: #fff;
            padding: 2 10px;
        }
        
        .error-message{
            color: red;
        }
        .message {
            width: 1px; /*  la largeur selon vos besoins */
             display: block;
             margin-top: -17px; /* Ajustez cette valeur pour déplacer le message vers le haut ou le bas */
             font-size: 1px; /* Ajustez la taille de la police selon vos préférences */
        }
        .input-group .form-control {
            padding-right: 40px; /* Adjust space for the icon */
        }
        .input-group .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            z-index: 2;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar" class=" vh-100">
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
                            <a href="chiercher.php" class="sidebar-link">Chercher un Tifo</a>
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

            <div class="d-4   flex-column  align-items-center justify-content-center min-vh-100">
    <div class="container text-center">
<div class="body">
<div class="message">
<?php include('message.php');?>
</div>
<div class="d-flex justify-content-center">
        <div class="form-section"> 
            <div class="form-container form-container-profile">
                <form action="" method="post">
                <div class="text">
                <p><h5>Modifier votre nom et email </h5></p>
                 </div>
                    <div class="form-group">
                    <div class="input-group  ">
                      <span class="input-group-text align-items-center"><i class="fas fa-user"></i></span>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Entrer votre nouveau nom" required>
                   </div>
                   </div>
                   <div class="form-group">
                   <div class="input-group">
                    <span class="input-group-text align-items-center"><i class="bi bi-envelope-fill"></i></span>
                   <input type="email" id="email" name="email" class="form-control" placeholder="Entrer votre nouveau email" required>
                        </div>
                    <span class="error-message"><?php if(isset($emailError)) { echo $emailError; } ?></span>
                    </div>
                    <div class="submit-btn-container">
                    <button type="submit" class="submit-btn" name="modify_profile">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="d-flex justify-content-center">
        <div class="separator separator-password"><span></span></div>
        </div>
        <div class="d-flex justify-content-center">
        <div class="form-section">
            <div class="form-container form-container-password">
            <form action="" method="post">
                <div class="text">
                <p><h5>Modifier votre mot de passe </h5></p>
           </div>
           <div class="form-group">
           <div class="input-group align-items-center">
            <span class="input-group-text"><i class="bi bi-unlock"></i></span>                       
            <input type="password" id="Oldpassword" name="Oldpassword" class="form-control" placeholder="Ancien mot de passe" required>
            <i class="uil uil-eye-slash toggle-password" style="cursor: pointer;"></i>
        </div>
              <span class="error-message"><?php if(isset($oldPasswordError)) { echo $oldPasswordError; } ?></span>
            </div>
             <div class="form-group">
           <div class="input-group align-items-center">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" id="Newpassword" name="Newpassword" class="form-control" placeholder="Nouveau mot de passe" required>
            <i class="uil uil-eye-slash toggle-password" style="cursor: pointer;"></i>

        </div>
            </div>
         <div class="form-group">
          <div class="input-group align-items-center">
        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
        <input type="password" id="password" name="password" class="form-control" placeholder="Confirmer mot de passe" required>
        <i class="uil uil-eye-slash toggle-password" style="cursor: pointer;"></i>

         </div>
              <span class="error-message"><?php if(isset($confirmPasswordError)) { echo $confirmPasswordError; } ?></span>
             </div>
                    <div class="submit-btn-container">
                    <button type="submit" class="submit-btn" name="modify_password">Modifier</button>
                   </div>
                </form>                





                </div>
                </div>
                </div>
               </div>
            </div>
        </div>        
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
// JavaScript pour basculer l'affichage du mot de passe
document.querySelectorAll('.toggle-password').forEach(function(icon) {
    icon.addEventListener('click', function () {
        const passwordField = icon.previousElementSibling;
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('uil-eye-slash');
            icon.classList.add('uil-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('uil-eye');
            icon.classList.add('uil-eye-slash');
        }
    });
});
</script>
</body>
</html>