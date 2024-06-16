<?php
require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('22166926449-28na0sq7cqvmk155pudg73tcbccfttor.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/crud/callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        // Handle the error case
        echo 'Error fetching the token: ' . htmlspecialchars($token['error']);
        exit();
    }

    $client->setAccessToken($token);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    // Extract user information
    $email = $userInfo->email;
    $name = $userInfo->name;

    // Check if the user exists in your database
    $conn = new mysqli('localhost', 'root', '', 'ultras');
    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }

    $query = $conn->prepare("SELECT * FROM leader WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // User exists, log them in
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location: home.php');
    } else {
        // User does not exist, create a new record
        $query = $conn->prepare("INSERT INTO leader (email, name) VALUES (?, ?)");
        $query->bind_param('ss', $email, $name);
        $query->execute();
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location: home.php');
    }

    $conn->close();
    exit();
} else {
    header('Location: sign.php');
    exit();
}
?>
