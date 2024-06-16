<?php
session_start ();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <style>
        .action-buttons {
            display: inline-block;
        }
        .action-column {
            white-space: nowrap; /* Empêcher le texte de se briser */
            width: 1%; /* Force la colonne à se réduire à la taille minimale */
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="wrapper">
        <!-- Translation Code here -->
					<span>
					    <div class="translate" id="google_translate_element"></div>

                            <script type="text/javascript">
                                function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
                            </script>
                            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					</span>
					<!-- Translation Code End here -->
        <aside id="sidebar">
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
                            <a href="#" class="sidebar-link">Chercher un Tifo</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="liste.php" class="sidebar-link">Liste des Tifos</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="imprimer.php" class="sidebar-link">Imprimer la liste des Tifos</a>
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
                    <a href="#" class="profile-link">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile</span>
                    </a>
                </div>
            </header>











































           







<div class="container mt-4">

<?php
if (isset($_POST['supp']) && isset($_POST['id_tifo'])) {
    $id_tifo = $_POST['id_tifo'];

    // Include the database connection
    include 'connexion.php';

    // Start a transaction
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

        echo '<div class="alert alert-success" role="alert">Ligne supprimée avec succès.</div>';
        echo '<script>
        setTimeout(function() {
            window.location.href = "?deleted";
        }, 3000); // Redirect after 1 second (1000 milliseconds)
        </script>';
    } catch (Exception $e) {
        // Rollback the transaction on error
        $con->rollback();

        echo "<script>alert('Échec de la suppression de la ligne : " . $e->getMessage() . "');</script>";
    }
}
?>



    <?php include('message.php');?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Liste des Tifos</h4>
                    <a href="ajout.php" class="btn btn-primary">Ajouter des Tifos</a>
                </div>
                <div class="card-body">
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
                                include 'connexion.php';

                                $num_per_page = 4;
                                if(isset($_GET['page'])){
                                    $page = $_GET['page'];
                                }
                                else{
                                    $page = 1;
                                }
                                $start_from = ($page - 1) * $num_per_page;

                                $req = "SELECT * FROM tifos LIMIT $start_from, $num_per_page";
                                $res = mysqli_query($con, $req);

                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_assoc($res)){
                                        echo "<tr class='text-center'>";
                                        echo "<td class='col-auto'>".$row["id_tifo"]."</td>";
                                        echo "<td><img src='data:image/jpeg/png;base64,".base64_encode($row['image'])."' width='100' /></td>";
                                        echo "<td>".$row["description"]."</td>";
                                        echo "<td>".$row["date_execution"]."</td>";
                                        echo "<td>".$row["temp_debut"]."</td>";
                                        echo "<td>".$row["email"]."</td>";
                                        echo "<td>".$row["motpasse"]."</td>";
                                        echo "<td class='action-column'>";
                                        echo '<div class="action-buttons">
                                                <form action="modifierr.php" method="post" class="d-inline">
                                                    <input type="hidden" name="id" value='.$row['id_tifo'].'>
                                                    <button type="submit" class="btn btn-primary btn-sm" name="modifier" value="voir">Modifier</button>
                                                </form>
                                                <form action="" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_tifo" value="'.$row['id_tifo'].'">
                                                    <button type="submit" name="supp" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce tifo ?\');">Supprimer</button>
                                                </form>
                                            </div>';
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="pagination justify-content-center">
                    <?php
                    $total_record = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tifos"));
                    $total_page = ceil($total_record / $num_per_page);
?>
                    <nav aria-label="Page navigation example">
    <ul class="pagination" >
        <?php if ($page > 1) : ?>
            <li class="page-item"><a class="page-link" href="liste.php?page=1">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="liste.php?page=<?php echo ($page - 1); ?>">&lsaquo;</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_page; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="liste.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $total_page) : ?>
            <li class="page-item"><a class="page-link" href="liste.php?page=<?php echo ($page + 1); ?>">&rsaquo;</a></li>
            <li class="page-item"><a class="page-link" href="liste.php?page=<?php echo $total_page; ?>">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>

            </div>
        </div>
    </div>
</div>
</div>
        </div>

       



<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>