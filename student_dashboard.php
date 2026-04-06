<?php
session_start();
include "database/db_config.php";

/* STUDENT PROTECTION */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['name'];

/* FETCH BLOGS */
$query = "
    SELECT blogs.id, blogs.title, blogs.content, users.name AS expert_name
    FROM blogs
    JOIN users ON blogs.expert_id = users.id
    ORDER BY blogs.id DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard | TechTales</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
}

/* BACKGROUND */
body {
    min-height: 100vh;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364,#1e3c72,#2a5298);
    background-size: 400% 400%;
    animation: moveBG 16s ease infinite;
    color: #fff;
}

@keyframes moveBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* HEADER */
.header {
    text-align: center;
    padding: 40px 20px;
}
.header h1 {
    font-size: 36px;
}
.header span {
    opacity: 0.9;
}

/* QUICK ACTIONS */
.actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 28px;
    padding: 30px 50px;
}

.action-card {
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(16px);
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.35);
    transition: 0.4s;
    cursor: pointer;
}
.action-card:hover {
    transform: translateY(-10px);
}

/* BLOG SECTION */
.section-title {
    text-align: center;
    font-size: 30px;
    margin: 30px 0;
}

.blog-section {
    padding: 20px 50px 60px;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
}

/* BLOG CARD */
.blog-card {
    background: rgba(255,255,255,0.20);
    backdrop-filter: blur(18px);
    border-radius: 26px;
    padding: 28px;
    box-shadow: 0 22px 45px rgba(0,0,0,0.4);
    transition: 0.4s;
}
.blog-card:hover {
    transform: translateY(-12px);
}

/* BLOG CONTENT */
.blog-title {
    font-size: 22px;
    margin-bottom: 8px;
}
.blog-meta {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 14px;
}
.blog-preview {
    font-size: 14.5px;
    line-height: 1.7;
}

/* READ BUTTON — FIXED */
.blog-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 11px 26px;
    border-radius: 28px;
    text-decoration: none;
    font-weight: 600;
    background: linear-gradient(135deg,#00c6ff,#0072ff);
    color: #fff;
    box-shadow: 0 12px 30px rgba(0,114,255,0.6);
    transition: 0.3s;
}
.blog-btn:hover {
    transform: translateY(-3px);
}

/* LOGOUT */
.logout {
    text-align: center;
    margin-bottom: 40px;
}
.logout a {
    color: #fff;
    text-decoration: none;
    padding: 12px 30px;
    border-radius: 28px;
    border: 1px solid rgba(255,255,255,0.6);
}
.logout a:hover {
    background: rgba(255,255,255,0.2);
}

/* RESPONSIVE */
@media(max-width:700px){
    .actions,.blog-section{padding:25px}
    .header h1{font-size:28px}
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>Welcome <?php echo htmlspecialchars($name); ?> 👋🎓</h1>
    <span>Learn • Explore • Ask • Grow</span>
</div>

<!-- QUICK ACTIONS -->
<div class="actions">
    <div class="action-card" onclick="alert('Ask Question coming soon')">
        <h2>❓ Ask a Question</h2>
        <p>Get help from experts</p>
    </div>
    <div class="action-card" onclick="alert('Answers coming soon')">
        <h2>💬 My Answers</h2>
        <p>View expert replies</p>
    </div>
    <div class="action-card" onclick="alert('Profile coming soon')">
        <h2>👤 My Profile</h2>
        <p>Manage your account</p>
    </div>
</div>

<!-- BLOGS -->
<h2 class="section-title">📚 Expert Blogs</h2>

<div class="blog-section">
    <div class="blog-grid">

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="blog-card">

            <div class="blog-title">
                <?php echo htmlspecialchars($row['title']); ?>
            </div>

            <div class="blog-meta">
                ✍️ <?php echo htmlspecialchars($row['expert_name']); ?>
            </div>

            <div class="blog-preview">
                <?php echo htmlspecialchars(substr($row['content'], 0, 150)); ?>...
            </div>

            <!-- ✅ WORKING LINK -->
            <a class="blog-btn"
               href="student_read_blog.php?id=<?php echo $row['id']; ?>">
               Read Blog →
            </a>

        </div>
        <?php } ?>

    </div>
</div>

<!-- LOGOUT -->
<div class="logout">
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
