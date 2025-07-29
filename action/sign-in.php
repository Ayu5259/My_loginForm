<?php
session_start();
require_once '../includes/loader.php';

if (isset($_POST['signin'])) {
    try {
        $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE (username = :key OR mobile = :key OR email = :key) AND is_verified = TRUE LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":key", $key);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../index.php?loginned=ok');
            exit;
        } else {
            header('Location: ../index.php?notuser=ok');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../index.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}
