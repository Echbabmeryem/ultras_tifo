<?php
require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('22166926449-28na0sq7cqvmk155pudg73tcbccfttor.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/crud/callback.php');
$client->addScope('email');
$client->addScope('profile');

$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit();
?>
