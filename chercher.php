<?php session_start();
include 'connexion.php';
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
                    <a href="compte.php" class="sidebar-link">
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
    <div class="container  mt-4">
        <div class="row">
            <div class="col-md-12">
                <?php include('message.php');?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Rechercher un Tifo</h4>
                        <a href="innnn.php"  class="btn btn-danger btn-sm" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;">Retour</a>
         
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Rechercher un tifo..." name="search">
                                <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['supp']) && isset($_POST['id_tifo'])) {
                            $id_tifo = $_POST['id_tifo'];
                           
                            $con->begin_transaction();
                
                            try {
                                $sql_membre_ids = "SELECT id_membre FROM membre WHERE id_tifo = ?";
                                $stmt_membre_ids = $con->prepare($sql_membre_ids);
                                $stmt_membre_ids->bind_param("i", $id_tifo);
                                $stmt_membre_ids->execute();
                                $result_membre_ids = $stmt_membre_ids->get_result();
                
                                while ($row = $result_membre_ids->fetch_assoc()) {
                                    $id_membre = $row['id_membre'];
                                    $sql_action = "DELETE FROM action WHERE id_membre = ?";
                                    $stmt_action = $con->prepare($sql_action);
                                    $stmt_action->bind_param("i", $id_membre);
                                    $stmt_action->execute();
                                }
                
                                $sql_membre = "DELETE FROM membre WHERE id_tifo = ?";
                                $stmt_membre = $con->prepare($sql_membre);
                                $stmt_membre->bind_param("i", $id_tifo);
                                $stmt_membre->execute();
                
                                $sql_tifo = "DELETE FROM tifos WHERE id_tifo = ?";
                                $stmt_tifo = $con->prepare($sql_tifo);
                                $stmt_tifo->bind_param("i", $id_tifo);
                                $stmt_tifo->execute();
                
                                $con->commit();
                
                                
                                $_SESSION['message'] ='Ligne supprimée avec succès.</div>';
                                echo '<script>
                        setTimeout(function() {
                            window.location.href = "?deleted";
                        }, 100); // Redirect after 1 second (1000 milliseconds)
                        </script>';
                                
                            } catch (Exception $e) {
                                $con->rollback();
                
                                echo "<script>alert('Échec de la suppression de la ligne : " . $e->getMessage() . "');</script>";
                            }
                        } 
                        
                        // Affichage des résultats de la recherche
                        if(isset($_POST['search'])){
                            $search_term = $_POST['search'];
                    
                            // Vérifie si l'utilisateur a entré plusieurs ID séparés par des virgules
                            if(strpos($search_term, ',') !== false){
                                // Recherche de plusieurs tifos
                                $search_terms = explode(",", $search_term);
                                $placeholders = rtrim(str_repeat('?,', count($search_terms)), ',');
                                $sql_search = "SELECT * FROM tifos WHERE id_tifo IN ($placeholders)";
                                
                                $stmt = $con->prepare($sql_search);
                                $stmt->bind_param(str_repeat('s', count($search_terms)), ...$search_terms);
                            } else {
                                // Recherche d'un seul tifo
                                $sql_search = "SELECT * FROM tifos WHERE id_tifo = ?";
                                $stmt = $con->prepare($sql_search);
                                $stmt->bind_param("s", $search_term);
                            }
                            $stmt->execute();

                            $result_search = $stmt->get_result();
                            if ($result_search->num_rows > 0) {
                                ?>
                                <div class="table-responsive">
                                    <table class='table table-bordered table-striped table-sm'>
                                        <thead>
                                            <tr class="text-center">
                                                <th class="col-auto">nbr</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Date d'exécution</th>
                                                <th>Temp début</th>
                                                <th>Email</th>
                                                <th>Mot de passe</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                while ($row = $result_search->fetch_assoc()) {
                    echo "<tr class='text-center'>";
                                                echo "<td class='col-auto'>" . $row["id_tifo"] . "</td>";
                                                echo "<td><img src='data:image/jpeg/png;base64," . base64_encode($row['image']) . "' width='100' /></td>";
                                                echo "<td>" . $row["description"] . "</td>";
                                                echo "<td>" . $row["date_execution"] . "</td>";
                                                echo "<td>" . $row["temp_debut"] . "</td>";
                                                echo "<td>" . $row["email"] . "</td>";
                                                echo "<td>" . $row["motpasse"] . "</td>";
                                                echo "<td class='action-column'>";
                                                echo '<div class="action-buttons">
                                                        <form action="update.php" method="post" class="d-inline">
                                                            <input type="hidden" name="id" value=' . $row['id_tifo'] . '>
                                                            <button type="submit" class="btn btn-primary btn-sm" name="voir" value="voir">Modifier</button>
                                                        </form>
                                                        <form action="" method="POST" class="d-inline" id="form_suppression_' . $row['id_tifo'] . '">
            <input type="hidden" name="id_tifo" value="' . $row['id_tifo'] . '">
            <button type="submit" name="supp" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce tifo ?\');">Supprimer</button>
        </form>
                                                    </div>';
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                                           
        
       
        ?>
                                        </tbody>
                                    </table>
                                </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div></div>
    <?php
                            } else {
                                $_SESSION['message']="Aucun résultat trouvé pour votre recherche";
                                echo '<script>window.location.href = "?noresult";</script>';
                            }
                        }
                        
                        ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script>document.getElementById("parametre").addEventListener("click", function() {
    window.location.href = "parametre.php";
});
</script>