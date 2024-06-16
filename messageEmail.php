<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer Email Aux membres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
       

        .form-control-sm {
            padding: 0.3rem 0.2rem;
            font-size: 0.87rem;
            height: auto;
        }
        .mb-2 {
            margin-bottom: 0.5rem !important;
        }
        .main {
            min-height: calc(100vh - 56px);
        }
        .btn-dark{
            background-color: #142e61e8;/* Custom background color */
    color: #ffffff; /* Custom text color */
    border: 2px solid #142e61e8; /* Custom border color */
    border-radius: 5px; /* Rounded corners */
        }
        
    </style>
</head>
<body>
    
    <div class="wrapper">
        <aside id="sidebar" class= "vh-100">
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
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
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
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#nouveau-menu" aria-expanded="false" aria-controls="nouveau-menu">
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
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#contact-menu" aria-expanded="false" aria-controls="contact-menu">
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
            
            <div class="main d-flex justify-content-center align-items-center">
                <div class="container">
                <div class="text">
            <h1 class="text-center">Send email</h1>
            <hr class="w-25 m-auto bg-dark">
        </div>
                    <form method="post" action="">
                        <div class="mb-2 row justify-content-center">
                            <div class="col-sm-7">
                                <label for="email" class="form-label  col-sm-3" style="font-size: 0.9rem;">Email</label>
                                <input type="email" class="form-control form-control-sm " name="email" id="email" placeholder="Entrer email d'ultras" required />
                            </div>
                        </div>
                        <div class="mb-2 row justify-content-center">
                            <div class="col-sm-7">
                                <label for="subject" class="form-label col-sm-3 " style="font-size: 0.9rem;">Objet</label>
                                <input type="text" class="form-control form-control-sm text-center" name="subject" id="subject" required />
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <div class="col-sm-7">
                                <label for="body" class="form-label " style="font-size: 0.9rem;">Message</label>
                                <textarea id="body" class="form-control form-control-sm" name="body" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-2 row justify-content-center">
                            <div class="col-sm-7  text-center">
                                <button type="submit" class="btn btn-dark btn-sm" name="envoyer">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


        </div>


    </div>
<script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/g5xgrsb7yjphgrd63coxo5va13vst314bhvr2z3ftrjqft3v/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#body',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 290,
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
        
        document.getElementById("parametre").addEventListener("click", function() {
    window.location.href = "parametre.php";
});

    
    </script>
</body>
</html>

<?php
if(isset($_POST['envoyer']))  {
   
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["body"];
}
else {
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
    
    try {
        // Configuration de l'envoi via SMTP
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'ultrasleader044@gmail.com';                     
        $mail->Password   = 'mobxtnmmpyqvkdbm';                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                    
    
        // Définition de l'expéditeur et du destinataire
        $mail->setFrom('ultrasleader044@gmail.com', 'Admin');
        $mail->addAddress($email);     

        // Configuration du message
        $mail->isHTML(true);                                
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Envoi du message
        $mail->send();
        echo "<script> alert('Message est envoyé avec succès');</script>";
    } catch (Exception $e) {
        echo "Message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
    }    

?>