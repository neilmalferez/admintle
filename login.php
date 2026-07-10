<?php
session_start();
require 'config.php';

$errorMessage = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);


    if (empty($email) || empty($password)) {
        $errorMessage = "Please fill in all fields.";
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_role"] = $user["role"];
                $_SESSION["user_name"] = $user["fname"] . " " . $user["lname"];


                if ($user["role"] === "admin") {
                    header("Location: admin-dashboard.php");
                } else {
                    header("Location: user-dashboard.php");
                }
                exit;
            } else {
                $errorMessage = "Invalid email or password.";
            }
        } else {
            $errorMessage = "No account found with that email.";
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
    <title>Login Page</title>
</head>

<body>
    <div class="background-wrapper">
        <div class="login-wrapper<?php echo $errorMessage !== "" ? " no-login-animation" : ""; ?>">
            <form method="POST">
                <div class="h2">
                    <h2>LOGIN</h2>
                    <p class="form-message" id="error-message"><?php echo htmlspecialchars($errorMessage); ?></p> <!-- Error Message -->
                </div>
                <div class="login-input">
                    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="login-input">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="login-input login-links">
                    <p><a href="register.php">Sign up</a></p>
                    <p><a href="forgot-password.php">Forgot password</a></p>
                </div>
                <div class="login-input">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    const email = document.querySelector("input[name='email']");
    const password = document.querySelector("input[name='password']");
    const form = document.querySelector("form");
    const message = document.getElementById("error-message"); 

    
    email.addEventListener("input", function () {
        this.value = this.value.replace(/[^A-Za-z0-9.@_-]/g, '');
    });

    
    form.addEventListener("submit", function (event) {
        message.textContent = "";

        if (password.value.length < 8) {
            message.textContent = "Password must be at least 8 characters long.";
            event.preventDefault();
            return;
        }
    });
});
</script> -->

</body>

</html>
