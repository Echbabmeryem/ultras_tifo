<?php
// Définir une variable pour suivre l'état de l'opération d'insertion
$insertionSuccess = false;
$imageName = ""; // Déclaration de la variable $imageName

// Initialiser les variables pour le nombre de lignes et de colonnes
$rows = 0;
$columns = 0;

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    // Chemin temporaire de l'image téléchargée
    $imageTmpPath = $_FILES["image"]["tmp_name"];

    // Charger l'image
    $image = imagecreatefromjpeg($imageTmpPath);

    if (!$image) {
        echo "Une erreur s'est produite lors du chargement de l'image.";
        exit;

    }

    $isInappropriate = checkForInappropriateContent($imageTmpPath);

    if ($isInappropriate) {
        echo "L'image téléchargée est inappropriée. Veuillez télécharger une autre image.";
        exit;
    }
    $uploadDirectory = "uploadss/"; // Changez ceci pour le chemin où vous souhaitez stocker les images téléchargées
     $imageName = $uploadDirectory . $_FILES["image"]["name"];
 
     // Déplacer l'image téléchargée vers le répertoire de téléchargement
     move_uploaded_file($imageTmpPath, $imageName);

    // Obtenir la largeur et la hauteur de l'image
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    // Mise à jour du nombre de lignes et de colonnes
    $rows = $imageHeight;
    $columns = $imageWidth;

    // Choisir une plage de valeurs proportionnelle à la plus petite dimension de l'image
    $coordinateRange = min($imageWidth, $imageHeight); // Utilise la plus petite dimension de l'image

    // Calculer le facteur d'échelle
    $scaleFactorX = $imageWidth / $coordinateRange;
    $scaleFactorY = $imageHeight / $coordinateRange;

    // Fonction de génération des données pour la première table
    function generateFirstTableData($image, $scaleFactorX, $scaleFactorY) {
        $tableData = array();
        for ($y = 0; $y < imagesy($image); $y++) {
            for ($x = 0; $x < imagesx($image); $x++) {
                // Obtenir la couleur du pixel à la position (x, y)
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

    $firstTableData = generateFirstTableData($image, $scaleFactorX, $scaleFactorY);

    
    $conn = new mysqli("localhost", "root", "", "tif");
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }
    foreach ($firstTableData as $row) {
        $sql_insert_membre = "INSERT INTO membre (coordonnees_x, coordonnees_y,id_tifo) VALUES ('" . $row['Coordonnée X'] . "', '" . $row['Coordonnée Y'] . "','" . $_POST['nbr'] . "')";

        if ($conn->query($sql_insert_membre) === TRUE) {
            $id_membre = $conn->insert_id;
    
            // Ensuite, insérez les données dans la table action en utilisant l'ID membre
            $sql_insert_action = "INSERT INTO action (id_membre ,couleur, chanson, duree ,mouvement, nbrs) VALUES ('$id_membre','" . $row['Couleur'] . "', '" . $_POST['nom_chanson'] . "', '" . $_POST['duree'] . "' ,'" . $_POST['mouvement'] . "','" . $_POST['nbrs'] . "')";
    
            if ($conn->query($sql_insert_action) === TRUE) {
                $insertionSuccess= true;
                
            } else {
                echo "Erreur lors de l'insertion dans la table action : " . $conn->error;
            }
        } else {
            echo "Erreur lors de l'insertion dans la table membre : " . $conn->error;
        }
    }
    // Fermer la connexion à la base de données
    $conn->close();
}
// Fonction pour vérifier si une image contient du contenu inapproprié
function checkForInappropriateContent($imagePath) {
    // Remplacez 'your_api_key' par votre clé d'API Vision de Google Cloud
    $apiKey = 'ad15aabce62caef7bba959628d9fe06a36125c28';
    // URL de l'API Vision de Google Cloud pour l'analyse de l'image
    $apiUrl = 'https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey;

    // Chemin de l'image à analyser
    $imageData = file_get_contents($imagePath);
    $base64Image = base64_encode($imageData);

    // Corps de la requête JSON pour l'analyse de l'image
    $jsonRequest = json_encode(array(
        'requests' => array(
            array(
                'image' => array(
                    'content' => $base64Image,
                ),
                'features' => array(
                    array(
                        'type' => 'SAFE_SEARCH_DETECTION',
                    ),
                ),
            ),
        ),
    ));

    // Configuration de la requête HTTP
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => $jsonRequest,
        ),
    );

    // Exécution de la requête HTTP
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    // Vérification si la requête a échoué
    if ($response === FALSE) {
        die('Erreur lors de la requête HTTP.');
    }

    // Affichage de la réponse brute pour le débogage
    var_dump($response);

    // Traitement de la réponse JSON
    $responseData = json_decode($response, true);

    // Vérification des erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Erreur de décodage JSON : ' . json_last_error_msg();
        return false;
    }

    // Vérification des résultats de l'analyse
    if (isset($responseData['responses'][0]['safeSearchAnnotation'])) {
        $annotations = $responseData['responses'][0]['safeSearchAnnotation'];

        // Vérifier si les annotations indiquent un contenu inapproprié
        if ($annotations['adult'] == 'VERY_LIKELY' || $annotations['violence'] == 'VERY_LIKELY' || $annotations['racy'] == 'VERY_LIKELY') {
            return true; // L'image est considérée comme inappropriée
        }
    }

    return false; // L'image est considérée comme appropriée
}


    // Afficher le tableau uniquement si l'insertion a réussi
    
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Planifier Tifo</h2>
    <form method="post" enctype="multipart/form-data">
    <label >Numero de tifo:</label><br>
        <input type="text" id="nbr" name="nbr"><br><br>
        <label> Choisissez une image</label>
        <input type="file" name="image" accept="image/*">
        <br>
        <label>Nombre total de durées:</label><br>
        <input type="text" name="nbrs" placeholder="Nombre total de durées"><br>
        
        <label>Choisissez le mouvement:</label><br>
        <select name="mouvement">
            <option value="gauche_droite">De gauche à droite</option>
            <option value="droite_gauche">De droite à gauche</option>
            <option value="haut_bas">De haut en bas</option>
            <option value="bas_haut">De bas en haut</option>
        </select><br>
        <label>Durée du Tifo</label>
        <input type="text" name="duree" placeholder="Durée"><br>
        <label>Chanson </label>
        <input type="text" name="nom_chanson" placeholder="Nom de la chanson"><br>
        <input type="button" name="Supprimer" value="Supprimer">
        <input type="button" name="Modifier"  value="Modifier"onclick="modifier()">

        <button type="submit">Enregistrer</button>
    </form>  
    <?php
    if ($insertionSuccess){
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Image</th>';
        echo '<th>Nombre de lignes</th>';
        echo '<th>Nombre de colonnes</th>';
        echo '<th>Nombre Total de position</th>'; // Correction : ajout de la balise de fermeture </th>
        echo '<th>Chanson</th>'; // Correction : ajustement de l'étiquette de colonne
        echo '<th>Durée</th>'; // Correction : ajustement de l'étiquette de colonne
        echo '</tr>';
        echo '<tr>';
        echo '<td><img src="' .  $imageName . '" width="100" /></td>';

        echo '<td>' . $rows . '</td>';
        echo '<td>' . $columns . '</td>';
        echo '<td>' . ($rows * $columns) . '</td>'; // Correction : affichage du nombre total de positions
        echo '<td>' . $_POST['nom_chanson'] . '</td>'; // Correction : afficher le nom de la chanson
        echo '<td>' . $_POST['duree'] . '</td>'; // Correction : afficher la durée
        echo '</tr>';
        echo '</table>';
        

        
    }        
    ?><script>
    // Fonction JavaScript pour confirmer la suppression et rediriger vers la page de traitement de la suppression
    function modifier() {
        if (confirm("Êtes-vous sûr de vouloir modifier cette entrée ?")) {
            window.location.href = "modifier.php"; // Redirection vers la page de suppression
        }
    }
    </script>
</body>
</html>
