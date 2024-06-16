<?php
session_start();

if (isset($_POST['login'])) {
    include('conn.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verify reCAPTCHA
    $recaptchaSecret = '6Lcs-b4pAAAAANbwXtNkCAc-grDQgClWRN_xcqRK';
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        $_SESSION['message'] = "Veuillez vérifier le CAPTCHA.";
        header('Location: sign.php');
        exit();
    }

    // Utilisation des requêtes préparées pour éviter les injections SQL
    $stmt = mysqli_prepare($con, "SELECT id, name, email, password FROM leader WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $name, $db_email, $db_password);
        mysqli_stmt_fetch($stmt);
        
        // Vérification du mot de passe haché
        if (password_verify($password, $db_password)) {
            // Authentification réussie
            $_SESSION['email'] = $db_email;
            $_SESSION['name'] = $name;
            $_SESSION['id'] = $id;
            
            // Stockage des cookies si "se souvenir de moi" est coché
            if (isset($_POST['remember'])) {
                $cookie_name = 'user';
                $cookie_value = $db_email;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // 86400 = 1 day
            }

            $_SESSION['message'] = "Connexion réussie.";
            header('Location: home.php');
            exit();
        } else {
            // Mot de passe incorrect
            $_SESSION['message'] = "Email ou mot de passe est incorrect.";
            header('Location: sign.php');
            exit();
        }
    } else {
        // Utilisateur non trouvé
        $_SESSION['message'] = "Email ou mot de passe est incorrect.";
        header('Location: sign.php');
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
