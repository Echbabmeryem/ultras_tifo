<?php
session_start();
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
    <link rel="stylesheet" href="style.css">
</head><style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

*, *::after, *::before {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

h1 {
    font-weight: 600;
    font-size: 1.5rem;
}

:root {
    --background-light: #d9d75af5;
    --background-dark: #e8eaef;
    --navbar-bg-light: #b2b1b1da;
    --navbar-bg-dark: #fcfcfcca;
    --sidebar-bg-light:#15171b;
    --sidebar-bg-dark: #1e1e2e;
    --text-light: #f9f9f9;
    --text-dark: #000000;
    --navbar-text-light: #090909;
    --navbar-text-dark: #131212;
    --sidebar-text-light: #ffffff;
    --sidebar-text-dark: #ffffff;
    --link-hover-light: rgba(58, 136, 182, 0.075);
    --link-hover-dark: rgba(58, 136, 182, 0.2);
    --border-left-light: #72e5e7;
    --border-left-dark: #ffa500;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--background-light);
    color: var(--text-dark); /* Fixer le texte en noir en dehors de la sidebar */
    transition: background-color 0.3s, color 0.3s;
}

body.dark-mode {
    background-color: var(--background-dark);
    color: var(--text-dark); /* Fixer le texte en noir en dehors de la sidebar */
}

.wrapper {
    display: flex;
    flex-direction: row;
}

#sidebar {
    width: 70px;
    min-width: 70px;
    z-index: 1000;
    transition: all 0.25s ease-in-out;
    background-color: var(--sidebar-bg-light);
    color: var(--sidebar-text-light); /* Fixer le texte en blanc dans la sidebar */
    display: flex;
    flex-direction: column;
}

body.dark-mode #sidebar {
    background-color: var(--sidebar-bg-dark);
    color: var(--sidebar-text-dark); /* Fixer le texte en blanc dans la sidebar */
}

#sidebar.expand {
    width: 230px;
    min-width: 230px;
}

.toggle-btn {
    background-color: transparent;
    cursor: pointer;
    border: 0;
    padding: 1rem 1.5rem;
}

.toggle-btn i {
    font-size: 1.5rem;
    color: #FFF;
}

.sidebar-logo {
    margin: auto 0;
}

.sidebar-logo a {
    color: #FFF;
    font-size: 1.15rem;
    font-weight: 600;
}

#sidebar:not(.expand) .sidebar-logo,
#sidebar:not(.expand) a.sidebar-link span {
    display: none;
}

.sidebar-nav {
    padding: 2rem 0;
    flex: 1 1 auto;
}

a.sidebar-link {
    padding: 0.625rem 1.625rem;
    color: var(--sidebar-text-light); /* Fixer le texte en blanc dans la sidebar */
    display: block;
    font-size: 0.9rem;
    white-space: nowrap;
    border-left: 3px solid transparent;
    transition: background-color 0.3s, border-left 0.3s;
}

a.sidebar-link:hover {
    background-color: var(--link-hover-light);
    border-left: 3px solid var(--border-left-light);
}

body.dark-mode a.sidebar-link:hover {
    background-color: var(--link-hover-dark);
    border-left: 3px solid var(--border-left-dark);
}

.sidebar-item {
    position: relative;
}

#sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
    position: absolute;
    top: 0;
    left: 70px;
    background-color: var(--sidebar-bg-light);
    padding: 0;
    min-width: 15rem;
    display: none;
}

body.dark-mode #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
    background-color: var(--sidebar-bg-dark);
}

#sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
    border: solid;
    border-width: 0 0.075rem 0.075rem 0;
    content: "";
    display: inline-block;
    padding: 2px;
    position: absolute;
    right: 1.5rem;
    top: 1.4rem;
    transform: rotate(-135deg);
    transition: transform 0.2s ease-out;
}

#sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
    transform: rotate(45deg);
}

.dropdown-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dropdown-menu {
    background-color: var(--sidebar-bg-light);
    padding: 0;
    border: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
}

body.dark-mode .dropdown-menu {
    background-color: var(--sidebar-bg-dark);
}

.dropdown-item {
    color: var(--sidebar-text-light); /* Fixer le texte en blanc dans la sidebar */
    padding: 0.625rem 1.625rem;
    display: block;
    font-size: 0.9rem;
    white-space: nowrap;
    border-left: 3px solid transparent;
}

.dropdown-item:hover {
    background-color: var(--link-hover-light);
    border-left: 3px solid var(--border-left-light);
}

body.dark-mode .dropdown-item:hover {
    background-color: var(--link-hover-dark);
    border-left: 3px solid var(--border-left-dark);
}

#sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
    display: block;
    max-height: 15em;
    width: 100%;
    opacity: 1;
}

#mode-toggle i {
    margin-right: 5px; /* Ajoutez un petit espace entre l'icône et le texte */
}

/* Navbar Styles */
.content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.navbar {
    width: 100%;
    background-color: var(--navbar-bg-light);
    color: var(--navbar-text-light);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 1rem 2rem;
    transition: background-color 0.3s, color 0.3s;
}

body.dark-mode .navbar {
    background-color: var(--navbar-bg-dark);
    color: var(--navbar-text-dark);
}

.navbar-profile .profile-link {
    color: var(--navbar-text-light);
    font-size: 1.2rem;
    display: flex;
    align-items: center;
}

body.dark-mode .navbar-profile .profile-link {
    color: var(--navbar-text-dark);
}

.profile-link i {
    font-size: 1.5rem;
    margin-right: 0.5rem;
}

body.dark-mode .profile-link i {
    color: var(--navbar-text-dark);
}

.profile-link:hover {
    color: var(--link-hover-light);
}

body.dark-mode .profile-link:hover {
    color: var(--link-hover-dark);
}

.main {
    min-height: 90vh;
    width: 100%;
    overflow: hidden;
    transition: all 0.35s ease-in-out;
    background-color: #fffefe;
}
.background-white {
    background-color: #ffffff; /* Blanc */
}
body {
    background-color: #ffffff; /* Fond blanc */
}

.card {
    background-color: #ffffff; /* Fond blanc pour les cartes */
           
}

.table {
    background-color: #ffffff; /* Fond blanc pour les tables */
}

.pagination {
    background-color: #ffffff; /* Fond blanc pour la pagination */
}

        .action-buttons {
            display: inline-block;
        }
        .action-column {
            white-space: nowrap; /* Empêcher le texte de se briser */
            width: 1%; /* Force la colonne à se réduire à la taille minimale */
        }
        
                /* Ajoutez une classe CSS pour les boutons d'action */
        .action-buttons button {
            background-color: #cfb845; /* Couleur bleue par défaut */
            color: #fff; /* Texte blanc */
        }
        
        /* Ajoutez une classe CSS pour les boutons de suppression */
        .action-buttons .btn-danger {
            background-color: #7fc3c0; /* Couleur rouge pour les boutons de suppression */
        }
        .card-body {
            padding: 10px; /* Réduit le padding intérieur */
            max-width: 100%; /* Définir la largeur maximale */
            max-height: 400px; /* Définir la hauteur maximale */
        }
    </style>
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
                            <a href="tet.php" class="sidebar-link">Liste des Tifos</a>
                            
                        </li>
                        <li class="sidebar-item">
                            <a href="msg.php" class="sidebar-link">Imprimer la liste des Tifos</a>
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
                            <a href="ll.php" class="sidebar-link">Définir une tâche</a>
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
                            <a href="email.php" class="sidebar-link">Contacter Leader</a>
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
                        <a  class=" profile-link dropdown-toggle bi bi-chevron-down" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Leader
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                          <li ><a class=" dropdown-item" href="change.php">changer Motpasse </a></li>
                          <li ><a class="  dropdown-item" href="logutleader.php">Deconnexion</a></li>
                          
                        </ul>
                </div>
            </header>

            <div class="container  background-white mt-4 ">
                <div class="row">
                    <div class="col-md-12">
                    <?php include('message.php'); ?>
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

                                            $num_per_page = 5;
                                            if (isset($_GET['page'])) {
                                                $page = $_GET['page'];
                                            } else {
                                                $page = 1;
                                            }
                                            $start_from = ($page - 1) * $num_per_page;

                                            $req = "SELECT * FROM tifos LIMIT $start_from, $num_per_page";
                                            $res = mysqli_query($con, $req);

                                            if (mysqli_num_rows($res) > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {
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
                                                            <form action="modifierr.php" method="post" class="d-inline">
                                                                <input type="hidden" name="id" value=' . $row['id_tifo'] . '>
                                                                <button type="submit" class="btn btn-primary btn-sm" name="voir" value="voir">Modifier</button>
                                                            </form>
                                                            <form action="" method="POST" class="d-inline">
                                                                <input type="hidden" name="id_tifo" value="' . $row['id_tifo'] . '">
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
                            <div class="pagination justify-content-center">
                                <?php
                                $total_record = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tifos"));
                                $total_page = ceil($total_record / $num_per_page);
                                ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php if ($page > 1) : ?>
                                            <li class="page-item"><a class="page-link" href="innnn.php?page=1">&laquo;</a></li>
                                            <li class="page-item"><a class="page-link" href="innnn.php?page=<?php echo ($page - 1); ?>">&lsaquo;</a></li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="innnn.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_page) : ?>
                                            <li class="page-item"><a class="page-link" href="innnn.php?page=<?php echo ($page + 1); ?>">&rsaquo;</a></li>
                                            <li class="page-item"><a class="page-link" href="innnn.php?page=<?php echo $total_page; ?>">&raquo;</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
        </div></div></div>

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

                echo '<div class="alert alert-success" role="alert">';
                $_SESSION['message'] ='Ligne supprimée avec succès.</div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "?deleted";
                        }, 1000); // Redirect after 1 second (1000 milliseconds)
                        </script>';
            } catch (Exception $e) {
                $con->rollback();

                echo "<script>alert('Échec de la suppression de la ligne : " . $e->getMessage() . "');</script>";
            }
        }
        ?>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>