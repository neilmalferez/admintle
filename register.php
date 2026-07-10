<?php
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST["fname"]);
    $lname = trim($_POST["lname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);


    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email already registered.";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            $query = "INSERT INTO users (fname, lname, email, password, role) VALUES (?, ?, ?, ?, 'user')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful. <a href='login.php'>Login here</a>";
            } else {
                $message = "Error: Could not register user.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.scss">
    <title>Register Page</title>
</head>

<body>
    <div class="background-wrapper">
        <div class="login-wrapper">
            <form method="POST">
                <div class="h2">
                    <h2>REGISTER</h2>
                    <p class="form-message"><?php echo $message; ?></p> <!-- MESSAGE -->
                </div>
                <div class="login-input">
                    <input type="text" name="fname" placeholder="First Name" required>
                </div>
                <div class="login-input">
                    <input type="text" name="lname" placeholder="Last Name" required>
                </div>
                <div class="login-input">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="login-input">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="login-input">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="login-input">
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fname = document.querySelector("input[name='fname']");
            const lname = document.querySelector("input[name='lname']");
            const email = document.querySelector("input[name='email']");
            const password = document.querySelector("input[name='password']");
            const confirmPassword = document.querySelector("input[name='confirm_password']");
            const form = document.querySelector("form");
            const message = document.querySelector(".form-message");


            const namePattern = /^[A-Za-z]*$/;
            fname.addEventListener("input", function() {
                if (!namePattern.test(this.value)) {
                    this.value = this.value.replace(/[^A-Za-z]/g, '');
                }
            });

            lname.addEventListener("input", function() {
                if (!namePattern.test(this.value)) {
                    this.value = this.value.replace(/[^A-Za-z]/g, '');
                }
            });


            email.addEventListener("input", function() {
                this.value = this.value.replace(/[^A-Za-z0-9.@_-]/g, '');
            });


            form.addEventListener("submit", function(event) {
                message.textContent = "";

                if (password.value.length < 8) {
                    message.textContent = "Password must be at least 8 characters long.";
                    event.preventDefault();
                    return;
                }
                if (password.value !== confirmPassword.value) {
                    message.textContent = "Passwords do not match.";
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>


</body>

</html>
