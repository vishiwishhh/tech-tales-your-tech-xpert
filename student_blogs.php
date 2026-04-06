<?php
session_start();
include "database/db_config.php";

/* STUDENT ACCESS */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit;
}

/* FETCH ALL BLOGS */
$query = "
    SELECT blogs.id, blogs.title, blogs.created_at, users.name AS expert_name
    FROM blogs
    JOIN users ON blogs.expert_id = users.id
    ORDER BY blogs.created_at DESC
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Blogs | TechTales</title>

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #00c9ff, #92fe9d);
    font-family: Poppins, sans-serif;
    padding: 40px;
}

.navbar {
    position: sticky;
    top: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 60px;
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(18px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.logo {
    font-size: 26px;
    font-weight: 700;
    color: #3b82f6;
}

.nav-links {
    display: flex;
    gap: 26px;
    align-items: center;
}

.nav-links a {
    text-decoration: none;
    font-weight: 500;
    color: #374151;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #2563eb;
}

.container {
    max-width: 900px;
    margin: auto;
}

.card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(15px);
    padding: 25px;
    border-radius: 20px;
    margin-bottom: 25px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.card h2 {
    margin-bottom: 8px;
    color: #0f4c5c;
}

.meta {
    font-size: 14px;
    color: #3a7f7f;
    margin-bottom: 15px;
}

.read {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 22px;
    border-radius: 20px;
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}
</style>
</head>

<body>

<div class="container">

    <h1>📚 Explore Blogs</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='card'>
                <h2>".htmlspecialchars($row['title'])."</h2>
                <div class='meta'>
                    ✍️ {$row['expert_name']} • ".date("F d, Y", strtotime($row['created_at']))."
                </div>
                <a class='read' href='student_read_blog.php?id={$row['id']}'>Read Blog →</a>
            </div>
            ";
        }
    } else {
        echo "<p>No blogs available.</p>";
    }
    ?>

</div>

</body>
</html>
