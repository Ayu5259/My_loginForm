<?php
session_start();
require_once '../includes/loader.php';
require 'vendor/autoload.php'; // برای PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['signup'])) {
    try {
        // اعتبارسنجی ورودی‌ها
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_STRING);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // رمزنگاری رمز عبور
        $verification_code = sprintf("%06d", mt_rand(100000, 999999)); // کد ۶ رقمی

        // بررسی وجود کاربر
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email OR mobile = :mobile");
        $stmt->execute(['username' => $username, 'email' => $email, 'mobile' => $mobile]);
        if ($stmt->rowCount() > 0) {
            header('Location: ../index.php?error=user_exists');
            exit;
        }

        // ثبت کاربر در دیتابیس
        $query = "INSERT INTO users (username, email, mobile, password, verification_code) VALUES (:username, :email, :mobile, :password, :code)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'mobile' => $mobile,
            'password' => $password,
            'code' => $verification_code
        ]);

        // ارسال ایمیل تأیید
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com';
        $mail->Password = 'your_app_password'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('your_email@gmail.com', 'سیستم احراز هویت');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'کد تأیید ایمیل';
        $mail->Body = "کد تأیید شما: <b>$verification_code</b><br>لطفاً این کد را در صفحه تأیید وارد کنید.";
        $mail->AltBody = "کد تأیید شما: $verification_code";

        $mail->send();

        // ذخیره ایمیل در session برای تأیید
        $_SESSION['email'] = $email;
        header('Location: ../otp.php');
        exit;
    } catch (PDOException $e) {
        header('Location: ../index.php?error=' . urlencode($e->getMessage()));
        exit;
    } catch (Exception $e) {
        header('Location: ../index.php?error=' . urlencode("خطا در ارسال ایمیل: " . $e->getMessage()));
        exit;
    }
}
