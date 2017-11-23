<?php
session_start();
require_once('model/config_google.php');

unset($_SESSION['id']);
unset($_SESSION['access_token']);
$google_client->revokeToken();

session_destroy();

header('Location: login.php');
exit();
?>