<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "database/db_config.php";
;

// ADMIN COUNT
$adminResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='admin'");
$adminCount = mysqli_fetch_assoc($adminResult)['total'];

// EXPERT COUNT
$expertResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='expert'");
$expertCount = mysqli_fetch_assoc($expertResult)['total'];

// STUDENT COUNT
$studentResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'");
$studentCount = mysqli_fetch_assoc($studentResult)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tech Tales Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <div class="nav-right" role="navigation" aria-label="Main menu">
      <nav class="links">
        <a href="register.php" class="link">register</a>
        <a href="login.php" class="link">login</a>
      </nav>

<div class="dashboard-container">
    <h1 class="title">Tech Tales – User Dashboard</h1>

    <div class="card-container">

        <div class="card admin-card" onclick="viewDetails('admin')">
            <h2>Admin</h2>
            <p>Total Admins</p>
            <span class="count"><?php echo $adminCount; ?></span>
        </div>

        <div class="card expert-card" onclick="viewDetails('expert')">
            <h2>Expert</h2>
            <p>Total Experts</p>
            <span class="count"><?php echo $expertCount; ?></span>
        </div>

        <div class="card student-card" onclick="viewDetails('student')">
            <h2>Student</h2>
            <p>Total Students</p>
            <span class="count"><?php echo $studentCount; ?></span>
        </div>

    </div>
</div>

<!-- ✅ JS ATTACHED HERE -->
<script src="script.js"></script>
</body>
</html>
