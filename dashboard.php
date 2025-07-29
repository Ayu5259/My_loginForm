<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: ../index.php");
    exit;
}
?>
<h1>Welcome! You are successfully signed in.</h1>