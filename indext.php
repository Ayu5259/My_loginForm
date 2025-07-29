<?php
session_start();
require_once 'includes/loader.php';
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود و ثبت‌نام</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container" id="container">
        <!-- فرم ثبت‌نام -->
        <div class="form-container sign-up">
            <form method="POST" action="./action/sign-up.php">
                <h1>ایجاد حساب کاربری</h1>
                <div class="social-icons">
                    <a href="#" class="icons"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icons"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>یا از ایمیل خود برای ثبت‌نام استفاده کنید</span>
                <input type="text" name="username" placeholder="نام کاربری" required>
                <input type="email" name="email" placeholder="ایمیل" required>
                <input type="text" name="mobile" placeholder="شماره موبایل" required>
                <input type="password" name="password" placeholder="رمز عبور" required>
                <button type="submit" name="signup">ثبت‌نام</button>
            </form>
        </div>

        <!-- فرم ورود -->
        <div class="form-container sign-in">
            <form method="POST" action="action/sign-in.php">
                <h1>ورود</h1>
                <br>
                <span>یا از ایمیل/نام کاربری/موبایل و رمز عبور استفاده کنید</span>
                <input type="text" name="key" placeholder="موبایل / نام کاربری / ایمیل" required>
                <input type="password" name="password" placeholder="رمز عبور" required>
                <a href="#">رمز عبور خود را فراموش کرده‌اید؟</a>
                <div style="display: inline;">
                    <button type="submit" name="signin">ورود</button>
                    <a style="margin-left: 15px" href="otp.php">ارسال OTP</a>
                </div>
                <?php if (isset($_GET['notuser'])) { ?>
                    <p style="width:100%" class="alert alert-danger">کاربر یافت نشد!</p>
                <?php } elseif (isset($_GET['loginned'])) { ?>
                    <p style="width:100%" class="alert alert-success">با موفقیت وارد شدید!</p>
                <?php } elseif (isset($_GET['error'])) { ?>
                    <p style="width:100%" class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php } elseif (isset($_GET['user_exists'])) { ?>
                    <p style="width:100%" class="alert alert-danger">نام کاربری، ایمیل یا موبایل قبلاً ثبت شده است!</p>
                <?php } ?>
            </form>
        </div>

        <!-- پنل تغییر -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>خوش آمدید!</h1>
                    <p>برای استفاده از تمام امکانات سایت، اطلاعات خود را وارد کنید</p>
                    <button class="hidden" id="login">ورود</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>سلام، دوست عزیز!</h1>
                    <p>برای استفاده از تمام امکانات سایت، ثبت‌نام کنید</p>
                    <button class="hidden" id="register">ثبت‌نام</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/script/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>