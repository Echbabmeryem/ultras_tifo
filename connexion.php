<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tif";

$con = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);


if ($con->connect_error) {
    die("La connexion a échoué : " . $con->connect_error);
}
?>