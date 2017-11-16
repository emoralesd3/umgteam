<?php
session_start();

unset($_SESSION['usuario']);
unset($_SESSION['id']);
unset($_SESSION['access_token']);

session_destroy();

header("Location: login.php");
?>