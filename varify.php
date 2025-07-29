<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['email'])) {
    header("Location: /action/sin-up.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $email = $_SESSION['email'];

    $stmt = $pdo->prepare("SELECT verification_code FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['verification_code'] == $code) {
        $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE, verification_code = NULL WHERE email = ?");
        $stmt->execute([$email]);
        unset($_SESSION['email']);
        header("Location: /action/sign-in.php");
        exit;
    } else {
        $error = "کد تأیید نامعتبر است.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تأیید ایمیل</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="container">
        <h2>تأیید ایمیل</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="code" placeholder="کد تأیید" required>
            <button type="submit">تأیید</button>
        </form>
    </div>
</body>
<script src="./assets/script/js/script.js"></script>

</html>