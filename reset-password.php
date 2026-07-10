<?php
session_start();
require 'config.php';

if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['email'])) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);


    $query = "UPDATE users SET password = ?, otp_code = NULL, otp_expiry = NULL WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $newPassword, $email);
    $stmt->execute();


    session_destroy();
    header("Location: login.php?message=Password reset successful");
    exit();
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
    <title>Document</title>
</head>

<body>
    <div class="background-wrapper">
        <div class="login-wrapper">
            <form method="POST">
                <div class="h2">
                    <h2>Reset Password</h2>
                </div>
                <div class="login-input">
                    <input type="password" name="password" placeholder="Enter new password" required>
                </div>
                <div class="login-input">
                    <button type="submit">Reset Password</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>