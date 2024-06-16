<?php
session_start();
?>
<?php
$insertionSuccess = false;
$imageName = ""; // Déclaration de la variable $imageName
$rows = 0;
$columns = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && isset($_POST['mouvment'])) {
    $imageTmpPath = $_FILES["image"]["tmp_name"];

    // Charger l'image
    $image = imagecreatefromjpeg($imageTmpPath);

    if (!$image) {
        echo "Une erreur s'est produite lors du chargement de l'image.";
        exit;
    }
    $uploadDirectory = "uploadss/"; 
     $imageName = $uploadDirectory . $_FILES["image"]["name"];
 
     
     move_uploaded_file($imageTmpPath, $imageName);




    
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    $rows = $imageHeight;
    $columns = $imageWidth;
    $coordinateRange = min($imageWidth, $imageHeight); // Utilise la plus petite dimension de l'image
    $scaleFactorX = $imageWidth / $coordinateRange;
    $scaleFactorY = $imageHeight / $coordinateRange;
    function generateFirstTableData($image, $scaleFactorX, $scaleFactorY) {
        $tableData = array();
        for ($y = 0; $y < imagesy($image); $y++) {
            for ($x = 0; $x < imagesx($image); $x++) {
                $colorIndex = imagecolorat($image, $x, $y);
                $rgb = imagecolorsforindex($image, $colorIndex);
                $hexColor = sprintf("#%02x%02x%02x", $rgb['red'], $rgb['green'], $rgb['blue']);
                $scaledX = $x + 1; // Ajouter 1 pour commencer à 1
                $scaledY = $y + 1; // Ajouter 1 pour commencer à 1
                $tableData[] = array('Coordonnée X' => $scaledX, 'Coordonnée Y' => $scaledY, 'Couleur' => $hexColor);
            }
        }
        return $tableData;
    }
    $nbrs = $_POST["nbrs"];
    $duree = $_POST["duree"];
    
    // Calculer le nombre de fois que la durée peut s'insérer complètement dans le nombre total
    $durernbrs =$duree/$nbrs;
    $minutes = floor($durernbrs);
    $secondes = round(($durernbrs - $minutes) * 60);
    $dureeFormattee = sprintf("%d:%02d", $minutes, $secondes);

    $firstTableData = generateFirstTableData($image, $scaleFactorX, $scaleFactorY);
    $conn = new mysqli("localhost", "root", "", "tif");
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }
    foreach ($firstTableData as $row) {
        $sql_insert_membre = "INSERT INTO membre (coordonnees_x, coordonnees_y,id_tifo) VALUES ('" . $row['Coordonnée X'] . "', '" . $row['Coordonnée Y'] . "','" . $_POST['nbr'] . "')";

        if ($conn->query($sql_insert_membre) === TRUE) {
            $id_membre = $conn->insert_id;
                $sql_insert_action = "INSERT INTO action (id_membre ,couleur, chanson, duree, mouvement,nbrs) VALUES ('$id_membre','" . $row['Couleur'] . "', '" . $_POST['nom_chanson'] . "', '" . $_POST['duree'] . "','" . $_POST['mouvment'] . "','".$_POST["nbrs"]."')"; // Correction : ajout de la colonne "mouvement"
    
            if ($conn->query($sql_insert_action) === TRUE) {
                $insertionSuccess= true;
                
            } else {
                $_SESSION['message'] ='Erreur lors de linsertion dans la table action : ' . $conn->error;
            }
        } else {
            $_SESSION['message'] ='Erreur lors de linsertion dans la table membre : ' . $conn->error;
        }
    }
    $conn->close();
}    

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body><div class="wrapper">
        <aside id="sidebar" class=" vh-100">
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
                            <a href="recherche.php" class="sidebar-link">Chercher un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="innnn.php" class="sidebar-link">Liste des Tifos</a>
                            
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
                            <a href="#" class="sidebar-link">Contacter Membre</a>
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
                    <li class="nav-item dropdown">
                        <a  class=" profile-link dropdown-toggle bi bi-chevron-down" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Leader
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                          <li ><a class=" dropdown-item" href="change.php">changer </a></li>
                          <li ><a class="  dropdown-item" href="logutleader.php">Deconnexion</a></li>
                          
                        </ul>
                    
                </div>
            </header>


    <div class="container background-white mt-4">
    <div class="row">
        <div class="col-md-12">
        <?php include('message.php'); ?>

            <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 >Planifier un Tifo</h4>
                <a href="innnn.php"  class="btn btn-danger">Retour</a>
            </div>
            <div class="card-body">
                <div class="center-form">


            <form  class="row g-3"method="post" enctype="multipart/form-data">

  <div class="col-md-4">
    <label for="nbr" class="form-label"> № de Tifo</label>
    <input type="text" class="form-control is-invalid" id="nbr" name="nbr"  placeholder="Entrer le numéro du tifo"required>
  </div>
  <div class="col-md-4">
    <label for="image" class="form-label">Image de Tifo</label>
    <input type="file" class="form-control is-invalid" id="image"  name="image" accept="image/*"   required onchange="processImage(event)">
  </div>
  <div class="col-md-4">
    <label for="nbrs" class="form-label">Nombre de senario</label>
    <div class="input-group has-validation">
      <input type="text" class="form-control is-invalid" id="nbrs" name="nbrs"  placeholder="Combien vous voulez diviser la durée " required>
      
    </div>
  </div>
  <div class="col-md-4">
    <label for="nom_chanson" class="form-label">Chanson</label>
    <input type="text" class="form-control is-invalid" id="nom_chanson" name="nom_chanson" placeholder="Entrer le nom de la chanson" required>
  </div>
  <div class="col-md-4">
    <label for="duree" class="form-label">Duree totales</label>
    <input class="form-control is-invalid" id="duree" placeholder="en min" name="duree"  required>
  </div>
  <div class="col-md-4">
    <label for="mouvment" class="form-label"> Sens de Mouvement </label>
    <select class="form-select is-invalid"name="mouvment" id="mouvment"  required>
      <option selected disabled value="">choisir...</option>
      <option> Haut -> Bas</option>
      <option>  Bas -> Haut</option>
      <option> Gauche -> Droit</option>
      <option> Droit -> Gauche</option>
    </select>
</div><div class="col-md-12 d-flex justify-content-center">
    <button type="submit" class="btn btn-primary  bg-dark btn-sm ">Enregistrer</button>
</div>

</form>
</div>
    <?php
    if ($insertionSuccess){
        echo '<table class="table table-striped table-bordered mt-4">';
        echo'  <thead>';
        echo '<tr>';
        echo '<th scope="col">Image de Tifo </th>';
        echo '<th scope="col">Nombre des lignes</th>';
        echo '<th scope="col">Nombre des colonnes</th>';
        echo '<th scope="col">Positions totales</th>'; // Correction : ajout de la balise de fermeture </th>
        echo '<th scope="col">Chanson</th>';
        echo '<th scope="col">Duree Totales</th>';
        echo '<th scope="col">Mouvement</th>'; 
        echo '<th scope="col">Duree de senario</th>';// Correction : ajout de la colonne pour le mouvement
        echo'</thead>';
        echo'<tbody class="table-group-divider">';
        echo '</tr>';
        echo '<tr>';
        echo '<td><img src="' .  $imageName . '" width="100" /></td>';

       
        echo '<td>' . $rows . '</td>';
        echo '<td>' . $columns . '</td>';
        echo '<td>' . ($rows * $columns) . '</td>'; // Correction : affichage du nombre total de positions
        echo '<td>' . $_POST['nom_chanson'] . '</td>'; // Afficher la chanson choisie
        echo '<td>' . $_POST['duree'] . '</td>'; 
        echo '<td>' . $_POST['mouvment'] . '</td>'; // Correction : affichage du mouvement
             echo '<td>' . $minutes .'minute(s)'. $secondes .'seconde(s)<br>';
        echo '</tr>';
        echo'</tbody>';

        echo '</table>';
    }        
    ?>
      </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
    <script>
    function processImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const width = img.width;
                    const height = img.height;
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                    document.getElementById('table-image').src = e.target.result;
                    document.getElementById('table-rows').innerText = height;
                    document.getElementById('table-columns').innerText = width;
                    document.getElementById('info-table').style.display = 'table';
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
    
    function checkFormFields() {
    var fields = document.querySelectorAll('.form-control'); // Sélectionnez tous les champs de formulaire avec la classe "form-control"
    fields.forEach(function(field) {
        // Vérifiez si le champ est vide
        if (field.value.trim() === '') {
            field.classList.remove('is-valid'); // Supprimez la classe "is-valid"
            field.classList.add('is-invalid'); // Ajoutez la classe "is-invalid" pour indiquer une erreur
        } else {
            field.classList.remove('is-invalid'); // Supprimez la classe "is-invalid"
            field.classList.add('is-valid'); // Ajoutez la classe "is-valid" pour indiquer que le champ est rempli correctement
        }
    });

    // Vérifiez spécifiquement le champ de sens de mouvement et remplacez is-invalid par is-valid s'il est sélectionné
    var mouvmentField = document.getElementById('mouvment');
    if (mouvmentField.value.trim() !== '') {
        mouvmentField.classList.remove('is-invalid');
        mouvmentField.classList.add('is-valid');
    }
}


    // Appelez la fonction checkFormFields lors de la soumission du formulaire
    document.querySelector('form').addEventListener('submit', function(event) {
        checkFormFields();
        // Empêchez la soumission du formulaire si un champ est vide
        if (document.querySelectorAll('.is-invalid').length > 0) {
            event.preventDefault();
        }
    });

    // Appelez la fonction checkFormFields lors de la modification des champs de formulaire
    document.querySelectorAll('.form-control').forEach(function(field) {
        field.addEventListener('input', function() {
            checkFormFields();
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>