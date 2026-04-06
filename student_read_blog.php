<?php
session_start();
include "database/db_config.php";

/* ===== STUDENT ACCESS ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit;
}

/* ===== BLOG ID CHECK ===== */
if (!isset($_GET['id'])) {
    header("Location: student_blogs.php");
    exit;
}

$blog_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

/* ===== FETCH BLOG ===== */
$blogQuery = "
    SELECT blogs.id, blogs.title, blogs.content, blogs.created_at,
           users.name AS expert_name
    FROM blogs
    JOIN users ON blogs.expert_id = users.id
    WHERE blogs.id = $blog_id
    LIMIT 1
";
$blogResult = mysqli_query($conn, $blogQuery);

if (mysqli_num_rows($blogResult) == 0) {
    header("Location: student_blogs.php");
    exit;
}

$blog = mysqli_fetch_assoc($blogResult);

/* ===== POST COMMENT ===== */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);

    if ($comment != "") {
        $insertComment = "
            INSERT INTO blog_comments (blog_id, student_id, comment)
            VALUES ($blog_id, $user_id, '$comment')
        ";
        mysqli_query($conn, $insertComment);
        header("Location: student_read_blog.php?id=$blog_id");
        exit;
    }
}

/* ===== FETCH COMMENTS ===== */
$commentQuery = "
    SELECT bc.id, bc.comment, bc.created_at,
           u.name AS student_name
    FROM blog_comments bc
    JOIN users u ON bc.student_id = u.id
    WHERE bc.blog_id = $blog_id
    ORDER BY bc.created_at DESC
";
$comments = mysqli_query($conn, $commentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($blog['title']); ?></title>

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
}

/* ===== BODY ===== */
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #00c9ff, #92fe9d, #38ef7d);
    background-size: 300% 300%;
    animation: bgMove 14s ease infinite;
    padding-top: 90px;
}

@keyframes bgMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ===== NAVBAR ===== */
.navbar {
    position: fixed;
    top: 15px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 1100px;
    padding: 14px 28px;
    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(18px);
    border-radius: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 999;
}

.navbar h2 {
    color: #0f4c5c;
    font-size: 22px;
}

.nav-links a {
    margin-left: 18px;
    padding: 10px 22px;
    border-radius: 22px;
    text-decoration: none;
    font-weight: 600;
    color: #0f4c5c;
    background: rgba(255,255,255,0.5);
    transition: 0.3s;
}

.nav-links a:hover {
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    color: #fff;
    box-shadow: 0 10px 25px rgba(0,201,255,0.6);
}

/* ===== CONTAINER ===== */
.container {
    max-width: 900px;
    margin: auto;
    background: rgba(255,255,255,0.8);
    padding: 40px;
    border-radius: 28px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
}

/* ===== BLOG ===== */
h1 {
    color: #0f4c5c;
    margin-bottom: 10px;
}

.meta {
    font-size: 14px;
    color: #3a7f7f;
    margin-bottom: 25px;
}

.content {
    font-size: 16.5px;
    line-height: 1.8;
    margin-bottom: 35px;
}

/* ===== COMMENT FORM ===== */
.comment-box textarea {
    width: 100%;
    padding: 15px;
    border-radius: 16px;
    border: none;
    resize: none;
}

.comment-box button {
    margin-top: 12px;
    padding: 10px 26px;
    border-radius: 24px;
    border: none;
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    color: #fff;
    cursor: pointer;
}

/* ===== COMMENTS ===== */
.comment {
    margin-top: 25px;
    padding: 18px;
    background: rgba(255,255,255,0.95);
    border-radius: 18px;
}

.reply {
    margin-top: 12px;
    margin-left: 30px;
    padding: 14px;
    background: rgba(0,201,255,0.15);
    border-radius: 14px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>📘 TechTales</h2>
    <div class="nav-links">
        <a href="student_dashboard.php">🏠 Home</a>
        <a href="student_blogs.php">📚 Blogs</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<div class="container">

    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>

    <div class="meta">
        ✍️ <?php echo htmlspecialchars($blog['expert_name']); ?> •
        <?php echo date("F d, Y", strtotime($blog['created_at'])); ?>
    </div>

    <div class="content">
        <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
    </div>

    <h3>💬 Ask / Comment</h3>
    <form method="POST" class="comment-box">
        <textarea name="comment" required placeholder="Ask your question..."></textarea>
        <button type="submit">Post Comment</button>
    </form>

    <h3 style="margin-top:35px;">🗨️ Discussion</h3>

    <?php while ($c = mysqli_fetch_assoc($comments)) { ?>
        <div class="comment">
            <strong><?php echo htmlspecialchars($c['student_name']); ?></strong><br>
            <?php echo htmlspecialchars($c['comment']); ?>

            <?php
            $cid = $c['id'];
            $replyQuery = "
                SELECT br.reply, u.name AS expert_name
                FROM blog_replies br
                JOIN users u ON br.expert_id = u.id
                WHERE br.comment_id = $cid
            ";
            $replies = mysqli_query($conn, $replyQuery);

            while ($r = mysqli_fetch_assoc($replies)) {
                echo "
                <div class='reply'>
                    <strong>Expert {$r['expert_name']}:</strong><br>
                    {$r['reply']}
                </div>
                ";
            }
            ?>
        </div>
    <?php } ?>

</div>

</body>
</html>
