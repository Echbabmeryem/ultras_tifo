<?php
session_start();

// Vérification des identifiants lors de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des identifiants (remplacez ceci par votre propre logique de vérification)
    $username = "utilisateur"; // Remplacez "utilisateur" par le nom d'utilisateur correct
    $password = "motdepasse"; // Remplacez "motdepasse" par le mot de passe correct

    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        // Les identifiants sont corrects, initialisez la session
        $_SESSION['loggedin'] = true;
        // Rediriger vers la page auth.php
        header('Location: auth.php');
        exit;
    } else {
        // Identifiants incorrects, rediriger vers une autre page ou afficher un message d'erreur
        header('Location: firstPage.php?error=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        /* Style pour le formulaire */
form {
    margin: auto;
    width: 300px;
    padding: 20px;
    border-radius: 5px;
    background-color: #f0f0f0;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 3px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Style pour les messages d'erreur */
.error-message {
    margin-top: 10px;
    color: #ff0000;
    font-size: 14px;
    font-style: italic;
}

    </style>
</head>
<body>
    <h1>Connexion</h1>
    <!-- Formulaire de connexion -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
