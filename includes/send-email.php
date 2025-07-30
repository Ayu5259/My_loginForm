<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function sendVerificationEmail($to, $code)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ayussssefi@gmail.com';
        $mail->Password = 'your_app_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'سیستم احراز هویت');
        $mail->addAddress($to);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'کد تأیید ایمیل';
        $mail->Body = "کد تأیید شما: $code\nلطفاً این کد را در صفحه تأیید وارد کنید.";
        $mail->send();
    } catch (Exception $e) {
        echo "خطا در ارسال ایمیل: {$mail->ErrorInfo}";
    }
}
