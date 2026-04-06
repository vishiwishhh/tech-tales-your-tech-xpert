<?php
// Backend logic
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "database/db_config.php";

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($name == "" || $email == "" || $password == "" || $role == "") {
        $message = "All fields are required.";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, email, password, role)
                  VALUES ('$name', '$email', '$hashedPassword', '$role')";

        if (mysqli_query($conn, $query)) {
            $message = "Registration successful! You can login now.";
        } else {
            $message = "Email already exists or error occurred.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | TechTales</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

<div class="register-container">
    <h2>Create Account</h2>

    <?php if ($message != "") { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST" onsubmit="return validateForm();">

        <input type="text" name="name" id="name" placeholder="Full Name">

        <input type="email" name="email" id="email" placeholder="Email Address">

        <input type="password" name="password" id="password" placeholder="Password">

        <select name="role" id="role">
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="expert">Expert</option>
        </select>

        <button type="submit">Register</button>
    </form>

    <p class="login-link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>
</div>

<script src="register.js"></script>
</body>
</html>
