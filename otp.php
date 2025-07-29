<?php
session_start();
require_once 'includes/loader.php';

if (!isset($_SESSION['email'])) {
  header('Location: index.php?error=' . urlencode('ابتدا ثبت‌نام کنید.'));
  exit;
}

if (isset($_POST['verify'])) {
  try {
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT verification_code FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && $user['verification_code'] === $code) {
      $stmt = $conn->prepare("UPDATE users SET is_verified = TRUE, verification_code = NULL WHERE email = :email");
      $stmt->execute(['email' => $email]);
      unset($_SESSION['email']);
      header('Location: index.php?loginned=ok');
      exit;
    } else {
      $error = "کد تأیید نامعتبر است.";
    }
  } catch (PDOException $e) {
    $error = "خطا: " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تأیید کد OTP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-in">
      <form method="POST" action="">
        <h1>تأیید کد OTP</h1>
        <br>
        <span>کد تأیید ارسال‌شده به ایمیل خود را وارد کنید</span>
        <input type="text" name="code" placeholder="کد تأیید" required>
        <?php if (isset($error)) { ?>
          <p style="width:100%" class="alert alert-danger"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <button type="submit" name="verify">تأیید</button>
      </form>
    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-right">
          <h1>سلام، دوست عزیز!</h1>
          <p>برای استفاده از تمام امکانات سایت، ثبت‌نام کنید</p>
          <button class="hidden" id="register" onclick="window.location.href='index.php'">ثبت‌نام</button>
        </div>
      </div>
    </div>
  </div>

  <script src="./assets/script/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>