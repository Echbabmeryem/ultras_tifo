<?php
require 'vendor/autoload.php';
    
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    // Vérifie si la CAPTCHA a été cochée
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        // Votre clé secrète de CAPTCHA
        $secret = '6Lcs-b4pAAAAANbwXtNkCAc-grDQgClWRN_xcqRK';
        
        // Vérifie la réponse de la CAPTCHA en envoyant une requête à l'API de reCAPTCHA
        $captcha_response = $_POST['g-recaptcha-response'];
        $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha_response}";
        $response = file_get_contents($verify_url);
        $response_data = json_decode($response);
        
        // Vérifie si la réponse de la CAPTCHA est valide
        if ($response_data && $response_data->success) {
            // La CAPTCHA est valide, affichez le message de succès
            echo "<script> alert('Captcha success! Your message here.');</script>";
        } else {
            // La CAPTCHA est invalide, affichez un message d'erreur
            echo "<script> alert('CAPTCHA verification failed.');</script>";
        }
    } else {
        // La CAPTCHA n'a pas été cochée, affichez un message d'erreur
        echo "<script> alert('Please check the CAPTCHA.'); </script>";
    }
} else {
    // Le formulaire n'a pas été soumis, redirigez ou affichez un message d'erreur approprié
    echo "<script> alert('Form not submitted.') ;</script>";
}
?>
