<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
</body>
</html>
<?php
include 'connexion.php';
$sql_select = "SELECT * FROM tifo";
$result = $con->query($sql_select);

// Afficher les tifos dans un tableau HTML
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>numero du tifo</th><th>image</th><th>Email</th><th>Mot de passe</th><th class='no-print'>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_tifo"] . "</td>";
        echo "<td><img src='data:image/jpeg/png;base64," . base64_encode($row['image']) . "' width='100' /></td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["motpasse"] . "</td>";
       
       
        echo '<td>';
            echo '
            <form action="modifierr.php" method="post" class="d-inline">
            <input type="hidden" name="id" value='.$row['id_tifo'].'>
            <button type="submit" class="btn btn-info mr-3" name="voir" value="voir">
                <i class="fas fa-pen"></i>
                 </button>
                 </form>
                 <form action="" method="POST" class="d-inline">

                 <input type="hidden" name="id" value="' . $row['id_tifo'] . '">
                 <button type="submit" name="delete_row" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce tifo?!\');">Supprimer</button>
                 
                 
                                               
                               </form>
</button>
</form> 
</td>
</tr>';
       
    }}
    if (isset($_POST['delete_row']) && isset($_POST['id'])) {
        $id_tifo = $_POST['id'];
        $sql = "DELETE FROM tifo WHERE id_tifo = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id_tifo);
       
        $stmt->execute();
        // Vérifie si la suppression a réussi
        if ( $stmt->affected_rows > 0) {
            echo '<div class="alert alert-success" role="alert">Ligne supprimé avec succès.</div>';
            echo '<script>
            setTimeout(function() {
                window.location.href = "?deleted";
            }, 1000); // Redirige après 2 secondes (2000 millisecondes)
          </script>';
    
            
            // Redirige l'utilisateur vers la même page après la suppression
           
            
        } else {
            echo "<script>alert('Échec de la suppression de la ligne');</script>";
        } 
    }
    