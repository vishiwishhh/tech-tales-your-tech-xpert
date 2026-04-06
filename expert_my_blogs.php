<?php
session_start();
include "database/db_config.php";

/* ===== EXPERT PROTECTION ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'expert') {
    header("Location: login.php");
    exit;
}

$expert_id = $_SESSION['user_id'];

/* ===== HANDLE REPLY SUBMISSION ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'], $_POST['comment_id'])) {
    $reply = trim($_POST['reply']);
    $comment_id = intval($_POST['comment_id']);

    if ($reply !== "") {
        $insertReply = "
            INSERT INTO blog_replies (comment_id, expert_id, reply)
            VALUES ($comment_id, $expert_id, '$reply')
        ";
        mysqli_query($conn, $insertReply);
    }
}

/* ===== FETCH EXPERT BLOGS ===== */
$blogsQuery = "
    SELECT id, title, content
    FROM blogs
    WHERE expert_id = $expert_id
    ORDER BY id DESC
";
$blogsResult = mysqli_query($conn, $blogsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Blogs & Replies | TechTales</title>

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
    background: linear-gradient(135deg, #11998e, #38ef7d);
    background-size: 300% 300%;
    animation: bgMove 14s ease infinite;
    padding-bottom: 50px;
}

@keyframes bgMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ===== NAVBAR ===== */
.navbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(18px);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.nav-left {
    font-size: 22px;
    font-weight: 700;
    color: #0f4c5c;
}

.nav-right a {
    margin-left: 18px;
    padding: 10px 22px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    color: #0f4c5c;
    background: rgba(255,255,255,0.6);
    transition: 0.3s;
}

.nav-right a:hover {
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    color: #fff;
    box-shadow: 0 10px 25px rgba(0,201,255,0.6);
}

/* ===== CONTAINER ===== */
.container {
    max-width: 1000px;
    margin: 50px auto 0;
    padding: 0 20px;
}

.container h1 {
    text-align: center;
    margin-bottom: 40px;
    color: #0f4c5c;
}

/* ===== BLOG CARD ===== */
.blog {
    background: rgba(255,255,255,0.85);
    border-radius: 26px;
    padding: 32px;
    margin-bottom: 40px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
}

.blog h2 {
    color: #0f4c5c;
    margin-bottom: 12px;
}

.blog-content {
    color: #333;
    line-height: 1.7;
    margin-bottom: 20px;
}

/* ===== COMMENT ===== */
.comment {
    margin-top: 22px;
    padding: 20px;
    border-radius: 18px;
    background: rgba(0,0,0,0.05);
}

.comment strong {
    color: #136f63;
}

/* ===== REPLY ===== */
.reply-box {
    margin-top: 14px;
}

.reply-box textarea {
    width: 100%;
    padding: 12px;
    border-radius: 14px;
    border: none;
    resize: none;
    font-size: 14px;
}

.reply-box button {
    margin-top: 10px;
    padding: 10px 26px;
    border-radius: 22px;
    border: none;
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.reply-box button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,201,255,0.6);
}

/* ===== EXISTING REPLY ===== */
.existing-reply {
    margin-top: 12px;
    padding: 14px;
    border-radius: 14px;
    background: rgba(0,201,255,0.15);
    color: #0b5ed7;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 700px) {
    .navbar {
        padding: 16px 20px;
        flex-direction: column;
        gap: 12px;
    }
}
</style>
</head>

<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <div class="nav-left">✨ TechTales Expert</div>
    <div class="nav-right">
        <a href="index.php">🏠 Home</a>
        <a href="expert_dashboard.php">📊 Dashboard</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="container">
    <h1>📝 My Blogs & Student Questions</h1>

<?php
while ($blog = mysqli_fetch_assoc($blogsResult)) {
    echo "<div class='blog'>";
    echo "<h2>".htmlspecialchars($blog['title'])."</h2>";
    echo "<div class='blog-content'>".nl2br(htmlspecialchars($blog['content']))."</div>";

    /* ===== FETCH COMMENTS ===== */
    $commentsQuery = "
        SELECT blog_comments.id, blog_comments.comment, users.name AS student_name
        FROM blog_comments
        JOIN users ON blog_comments.student_id = users.id
        WHERE blog_comments.blog_id = {$blog['id']}
        ORDER BY blog_comments.id DESC
    ";
    $commentsResult = mysqli_query($conn, $commentsQuery);

    if (mysqli_num_rows($commentsResult) == 0) {
        echo "<p><em>No questions yet.</em></p>";
    }

    while ($comment = mysqli_fetch_assoc($commentsResult)) {
        echo "<div class='comment'>";
        echo "<strong>❓ {$comment['student_name']}:</strong><br>";
        echo htmlspecialchars($comment['comment']);

        /* ===== FETCH REPLY ===== */
        $replyQuery = "
            SELECT reply
            FROM blog_replies
            WHERE comment_id = {$comment['id']}
            LIMIT 1
        ";
        $replyResult = mysqli_query($conn, $replyQuery);

        if (mysqli_num_rows($replyResult) > 0) {
            $reply = mysqli_fetch_assoc($replyResult);
            echo "<div class='existing-reply'>
                    💬 <strong>Your reply:</strong><br>
                    ".htmlspecialchars($reply['reply'])."
                  </div>";
        } else {
            echo "
            <form method='POST' class='reply-box'>
                <input type='hidden' name='comment_id' value='{$comment['id']}'>
                <textarea name='reply' placeholder='Write your reply...'></textarea>
                <button type='submit'>Reply</button>
            </form>
            ";
        }

        echo "</div>";
    }

    echo "</div>";
}
?>

</div>

</body>
</html>
