<?php
include 'connexion.php';

    if(isset($_REQUEST['voir'])){
        $req="SELECT * FROM `tifo` WHERE id_tifo={$_REQUEST['id']}";
            $res=mysqli_query($con,$req);
            $row=mysqli_fetch_assoc($res);
           
    }
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Tifo</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="current_image" value="<?php echo isset($_POST['current_image']) ? $_POST['current_image'] : (isset($row['image']) ? base64_encode($row['image']) : ''); ?>">
        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : (isset($row['id_tifo']) ? $row['id_tifo'] : ''); ?>">

        <label for="current_image" class="form-label">Image actuelle</label>
        <img src="data:image/jpeg;base64,<?php echo isset($_POST['current_image']) ? $_POST['current_image'] : (isset($row['image']) ? base64_encode($row['image']) : ''); ?>" width="100" /><br />
        <label for="new_image" class="form-label">Nouvelle image</label>
        <input type="file" id="new_image" accept="image/*" class="form-control" name="new_image">
        <label for="email" class="form-label">email</label>
        <input class="form-control" id="adresse" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : (isset($row['email']) ? $row['email'] : ''); ?>">

        <label for="password" class="form-label">password</label>
        <input class="form-control" id="adresse" name="motdpasse" value="<?php echo isset($_POST['motdpasse']) ? $_POST['motdpasse'] : (isset($row['motpasse']) ? $row['motpasse'] : ''); ?>">

        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" rows="4" cols="50"><?php echo isset($_POST['description']) ? $_POST['description'] : (isset($row['description']) ? $row['description'] : ''); ?></textarea>

        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" value="<?php echo isset($_POST['date']) ? $_POST['date'] : (isset($row['date_execution']) ? $row['date_execution'] : ''); ?>" name="date">

        <label for="tempD" class="form-label">Heure de début du tifo</label>
        <input type="time" class="form-control" value="<?php echo isset($_POST['tempD']) ? $_POST['tempD'] : (isset($row['temp_debut']) ? $row['temp_debut'] : ''); ?>" name="tempD">

        <button type="submit" class="btn btn-warning" name="update">Enregistrer</button>
    </form>

    
</body>
</html>











<?php
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pwd = $_POST['motdpasse'];
    $desc = $_POST['description'];
    $date = $_POST['date'];
    $tempD = $_POST['tempD'];
    
    if(isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['new_image']['tmp_name']); // Récupération du contenu du fichier
    } else {
        // Utiliser l'image existante si aucun fichier n'a été téléchargé
        $image = base64_decode($_POST['current_image']);
    }
    $reqq = "UPDATE `tifo` SET image=?, email=?, motpasse=?, description=?, date_execution=?, temp_debut=? WHERE id_tifo=?";
    $stmt = $con->prepare($reqq);
    $stmt->bind_param("ssssssi", $image, $email, $pwd, $desc, $date, $tempD,  $id);
    
    if($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Ligne modifiée avec succès.</div>';
        // Redirection vers la page principale après 2 secondes
        echo '<script>
            setTimeout(function() {
                window.location.href = "modifier.php";
            }, 2000);
        </script>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Erreur lors de la modification de la ligne.</div>';
    }
}

