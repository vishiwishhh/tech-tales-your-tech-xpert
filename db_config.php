<?php
$conn = mysqli_connect("localhost", "root", "", "tech_tales");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
