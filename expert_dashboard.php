<?php
session_start();

/* Simple protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'expert') {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['name'] ?? "Expert";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Expert Dashboard | TechTales</title>

<style>
/* ========= RESET ========= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
}

/* ========= BODY ========= */
body {
    min-height: 100vh;
    background: linear-gradient(
        135deg,
        #fbc2eb,
        #a6c1ee,
        #fddb92,
        #c2e9fb
    );
    background-size: 300% 300%;
    animation: pastelMove 16s ease infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2f2f2f;
}

@keyframes pastelMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ========= GLASS ========= */
.glass {
    width: 90%;
    max-width: 1000px;
    padding: 45px;
    border-radius: 26px;
    background: rgba(255, 255, 255, 0.45);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ========= HEADER ========= */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.header h2 {
    font-size: 30px;
    font-weight: 600;
    color: #444;
}

/* ========= LOGOUT ========= */
.logout {
    padding: 12px 22px;
    border-radius: 30px;
    text-decoration: none;
    color: #fff;
    background: linear-gradient(135deg, #f6a5c0, #b39ddb);
    box-shadow: 0 8px 20px rgba(179,157,219,0.45);
    transition: 0.35s;
}

.logout:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(179,157,219,0.65);
}

/* ========= CARDS ========= */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 28px;
}

.card {
    position: relative;
    padding: 30px;
    border-radius: 22px;
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(12px);
    transition: all 0.4s ease;
    cursor: pointer;
    overflow: hidden;
}

.card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 22px;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,0.8),
        transparent
    );
    opacity: 0;
    transition: 0.4s;
}

.card:hover::before {
    opacity: 1;
}

.card:hover {
    transform: translateY(-12px) scale(1.04);
    box-shadow: 0 18px 35px rgba(0,0,0,0.18);
}

.card h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #555;
}

.card p {
    font-size: 14.5px;
    line-height: 1.6;
    color: #666;
}

/* Link inside card */
.card a {
    font-size: 18px;
    font-weight: 600;
    color: #6a5acd;
    text-decoration: none;
}

.card a:hover {
    text-decoration: underline;
}

/* ========= FOOTER ========= */
.footer {
    margin-top: 40px;
    text-align: center;
    font-size: 14px;
    color: #777;
}

/* ========= RESPONSIVE ========= */
@media (max-width: 600px) {
    .glass {
        padding: 30px 22px;
    }

    .header h2 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<div class="glass">

    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="cards">
       <div class="card" onclick="window.location.href='expert_blog.php'">
            <h3>📝 Post Blog</h3>
    <p>Share your knowledge and latest tech insights.</p>
    </div>


        <div class="card" onclick="window.location.href='expert_my_blogs.php'">
            <h3>📚 My Blogs</h3>
            <p>Manage blogs you have written.</p>
        </div>

        <div class="card" onclick="comingSoon('Answer Questions')">
            <h3>💬 Answer Questions</h3>
            <p>Help students by answering their doubts.</p>
        </div>

        <div class="card" onclick="comingSoon('Profile')">
            <h3>👤 Profile</h3>
            <p>View and update your expert profile.</p>
        </div>
    </div>

    <div class="footer">
        TechTales • Your Tech Expert
    </div>
</div>

<script>
function comingSoon(feature) {
    alert(feature + " feature coming soon 🌱");
}
</script>

</body>
</html>
