<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    include('conn.php');

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message_register'] = "Tous les champs sont obligatoires.";
        header('Location: register.php');
        exit;
    }

    if (substr($email, -10) !== "@gmail.com") {
        $_SESSION['error_message_register'] = "L'email doit être un email @gmail.com.";
        header('Location: register.php');
        exit;
    }
    

    if (strlen($password) < 4) {
        $_SESSION['error_message_register'] = "Le mot de passe doit contenir au moins 4 caractères.";
        header('Location: register.php');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error_message_register'] = "Les mots de passe ne correspondent pas.";
        header('Location: register.php');
        exit;
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Utilisation des requêtes préparées pour éviter les injections SQL
    $stmt = mysqli_prepare($con, "SELECT * FROM leader WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error_message_register'] = "Email déjà utilisé.";
        header('Location: register.php');
        exit;
    } else {
        // Insertion de l'utilisateur dans la base de données
        $stmt = mysqli_prepare($con, "INSERT INTO leader (name, email, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        mysqli_stmt_execute($stmt);

        $_SESSION['name'] = $name;
        $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header('Location: sign.php');
        exit;
    }
}
?>
