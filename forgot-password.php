<?php
session_start();
require 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);


    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));


        $updateQuery = "UPDATE users SET otp_code = ?, otp_expiry = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sss", $otp, $expiry, $email);
        $stmt->execute();


        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'miraculous.knight109@gmail.com';
            $mail->Password = 'otcdplpsgaahvsnl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('miraculous.knight109@gmail.com', 'Your App Name');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset OTP";
            $mail->Body = "Your OTP for password reset is <b>$otp</b>. It expires in 10 minutes.";

            $mail->send();
            $_SESSION['email'] = $email;
            header("Location: verify-otp.php");
            exit();
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>window.alert('GFasda')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.scss">
    <style>
        h2 {
            height: 70px;
            font-size: 25px;
            text-align: center;
        }

        .login-input {
            margin-bottom: 10px;
        }
    </style>

<body>
    <div class="background-wrapper">
        <div class="login-wrapper">
            <form method="POST">
                <div class="h2">
                    <h2>Reset Password</h2>
                </div>
                <div class="login-input">
                    <label for=""></label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="login-input">
                    <button type="submit">Send OTP</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>