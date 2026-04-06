<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "database/db_config.php";

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email == "" || $password == "") {
        $message = "All fields are required.";
    } else {

        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {

                // Store session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                // Role based redirect
                if ($user['role'] == 'student') {
                    header("Location: student_dashboard.php");
                } elseif ($user['role'] == 'expert') {
                    header("Location: expert_dashboard.php");
                } else {
                    header("Location: dashboard.php"); // admin
                }
                exit;

            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "Account not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | TechTales</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Login to TechTales</h2>

    <?php if ($message != "") { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST" onsubmit="return validateLogin();">

        <input type="email" name="email" id="email" placeholder="Email">

        <input type="password" name="password" id="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>

    <p class="register-link">
        Don’t have an account?
        <a href="register.php">Register</a>
    </p>
</div>

<script src="login.js"></script>
</body>
</html>
