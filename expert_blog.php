<?php
session_start();
include "database/db_config.php";

/* ===== SECURITY CHECK ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'expert') {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $expert_id = $_SESSION['user_id'];

    if ($title == "" || $content == "") {
        $message = "All fields are required.";
    } else {
        $query = "INSERT INTO blogs (expert_id, title, content)
                  VALUES ('$expert_id', '$title', '$content')";

        if (mysqli_query($conn, $query)) {
            $message = "Blog posted successfully 🌊";
        } else {
            $message = "Error posting blog.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Post Blog | Expert</title>

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
}

/* ===== BODY BACKGROUND ===== */
body {
    min-height: 100vh;
    background: linear-gradient(
        135deg,
        #00c9ff,
        #92fe9d,
        #38ef7d,
        #43cea2
    );
    background-size: 400% 400%;
    animation: oceanMove 14s ease infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0f2d2d;
}

@keyframes oceanMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ===== BLOG CARD ===== */
.blog-box {
    width: 90%;
    max-width: 520px;
    padding: 40px;
    border-radius: 26px;
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    box-shadow:
        0 30px 60px rgba(0,0,0,0.18),
        inset 0 0 0 1px rgba(255,255,255,0.6);
    animation: fadeUp 0.9s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== TITLE ===== */
.blog-box h2 {
    text-align: center;
    margin-bottom: 22px;
    font-size: 28px;
    font-weight: 600;
    color: #1e6f6f;
}

/* ===== MESSAGE ===== */
.message {
    text-align: center;
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 12px;
    background: rgba(56, 239, 125, 0.15);
    color: #136f63;
    font-weight: 500;
}

/* ===== INPUTS ===== */
input,
textarea {
    width: 100%;
    padding: 14px 16px;
    margin: 12px 0;
    border-radius: 14px;
    border: none;
    outline: none;
    font-size: 15px;
    background: rgba(255,255,255,0.85);
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.08);
    transition: 0.3s;
}

input:focus,
textarea:focus {
    transform: scale(1.02);
    box-shadow: 0 0 0 2px rgba(0, 201, 255, 0.35);
}

textarea {
    min-height: 160px;
    resize: none;
}

/* ===== BUTTON ===== */
button {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    border-radius: 30px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #00c9ff, #38ef7d);
    box-shadow: 0 12px 30px rgba(0,201,255,0.45);
    transition: all 0.35s ease;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(0,201,255,0.6);
}

/* ===== BACK LINK ===== */
.back-link {
    margin-top: 22px;
    text-align: center;
}

.back-link a {
    text-decoration: none;
    font-weight: 600;
    color: #1b7f79;
    transition: 0.3s;
}

.back-link a:hover {
    text-decoration: underline;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
    .blog-box {
        padding: 30px 22px;
    }

    .blog-box h2 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<div class="blog-box">
    <h2>📝 Post a New Blog</h2>

    <?php if ($message != "") { ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Blog Title">
        <textarea name="content" placeholder="Write your blog content here..."></textarea>
        <button type="submit">🌊 Publish Blog</button>
    </form>

    <div class="back-link">
        <a href="expert_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
