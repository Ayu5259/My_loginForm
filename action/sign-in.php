<?php
require_once('../config/loader.php');

if (isset($_POST['signin'])) {
    try {
        // parametrs
        $key = $_POST['key'];
        $password = $_POST['password'];

        // sql
        $query = "SELECT * FROM `users` WHERE (username = :key OR mobile = :key OR email = :key) AND (password = :password) LIMIT 1";

        // stmt
        $stmt = $conn->prepare($query);

        // bind
        $stmt->bindValue(":key", $key);
        $stmt->bindValue(":password", $password);

        // exe
        $stmt->execute();

        $hasUser = $stmt->rowCount();

        if ($hasUser) {
            header('Location: ../index.php?loginned=ok');
        } else {
            header('Location: ../index.php?notuser=ok');
        }

        // echo "Created Account";
        // header('Location: ../index.php');
    } catch (PDOException $e) {
        echo "Your error message is : " . $e->getMessage();
    }
}
