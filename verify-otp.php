<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $otp = trim($_POST['otp']);


    $query = "SELECT * FROM users WHERE email = ? AND otp_code = ? AND otp_expiry > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset-password.php");
        exit();
    } else {
        echo "Invalid or expired OTP.";
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
    <title>Document</title>
</head>

<body>
    <div class="background-wrapper">
        <div class="login-wrapper">
            <form method="POST">
                <div class="h2">
                    <h2>Reset Password</h2>
                    <p style="margin-top: 10px">
                        <?php
                        echo ($_SESSION['email']);
                        ?>
                    </p>
                </div>
                <div class="login-input">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                </div>
                <div class="login-input">
                    <button type="submit">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>