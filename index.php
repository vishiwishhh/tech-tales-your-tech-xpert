<?php
session_start();
include "database/db_config.php";

$role = $_SESSION['role'] ?? null;
$name = $_SESSION['name'] ?? null;

/* LIVE COUNTS */
$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

$totalExperts = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='expert'")
)['total'];

$totalStudents = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='student'")
)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TechTales | Learn from Experts</title>

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
    scroll-behavior: smooth;
}

/* ===== BODY ===== */
body {
    background: linear-gradient(
        180deg,
        #fbc2eb,
        #a6c1ee,
        #d4fcff,
        #c2ffd8,
        #e0c3fc
    );
    background-size: 100% 500%;
    animation: bgFlow 25s ease infinite;
    color: #1f2933;
}

@keyframes bgFlow {
    0% { background-position: 0% 0%; }
    50% { background-position: 0% 100%; }
    100% { background-position: 0% 0%; }
}

/* ===== NAVBAR ===== */
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

/* Buttons */
.btn {
    padding: 10px 22px;
    border-radius: 22px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #60a5fa, #818cf8);
    color: #fff;
    box-shadow: 0 8px 25px rgba(99,102,241,0.45);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(99,102,241,0.7);
}

.btn-outline {
    border: 1px solid #6366f1;
    color: #4f46e5;
}

.btn-outline:hover {
    background: rgba(99,102,241,0.1);
}

/* ===== SECTION BASE ===== */
section {
    padding: 110px 80px;
}

.section-title {
    font-size: 40px;
    margin-bottom: 30px;
    text-align: center;
}

.section-sub {
    max-width: 850px;
    margin: auto;
    font-size: 18px;
    line-height: 1.8;
    text-align: center;
    opacity: 0.95;
}

/* ===== ABOUT ===== */
.about {
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(16px);
}

/* ===== STORY ===== */
.story-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px,1fr));
    gap: 35px;
    margin-top: 50px;
}

.story-card {
    background: rgba(255,255,255,0.6);
    border-radius: 26px;
    padding: 35px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.15);
    transition: 0.4s;
}

.story-card:hover {
    transform: translateY(-12px);
}

/* ===== STORY STATS ===== */
.story-stats {
    margin-top: 70px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 35px;
}

.stat-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 22px 45px rgba(0,0,0,0.18);
    transition: 0.45s;
}

.stat-card:hover {
    transform: translateY(-14px) scale(1.03);
}

.stat-number {
    font-size: 42px;
    font-weight: 700;
    background: linear-gradient(135deg, #3b82f6, #22c55e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-label {
    margin-top: 10px;
    font-size: 16px;
    font-weight: 500;
    opacity: 0.9;
}

/* ===== WHY ===== */
.why {
    background: linear-gradient(135deg, #d4fcff, #e0c3fc);
}

.why-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
    gap: 30px;
    margin-top: 45px;
}

.why-card {
    background: rgba(255,255,255,0.7);
    padding: 30px;
    border-radius: 22px;
    text-align: center;
    box-shadow: 0 16px 35px rgba(0,0,0,0.15);
}

/* =====MISSION  ===== */
.mission {
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(16px);
}

/* ===== STORY ===== */
.mission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px,1fr));
    gap: 35px;
    margin-top: 50px;
}

.mission-card {
    background: rgba(255,255,255,0.6);
    border-radius: 26px;
    padding: 35px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.15);
    transition: 0.4s;
}

.mission-card:hover {
    transform: translateY(-12px);
}

/* ===== CTA ===== */
.cta {
    background: linear-gradient(135deg, #60a5fa, #34d399);
    color: #fff;
    text-align: center;
}

.cta h2 {
    font-size: 42px;
    margin-bottom: 20px;
}

.cta p {
    font-size: 18px;
    margin-bottom: 35px;
}

/* ===== FOOTER ===== */
.footer {
    padding: 40px;
    text-align: center;
    font-size: 14px;
    opacity: 0.85;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    section { padding: 80px 25px; }
    .section-title { font-size: 30px; }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">TechTales</div>
    <div class="nav-links">
        <a href="#about">About</a>
        <a href="#story">Journey</a>
        <a href="#why">Why Us</a>

        <?php if (!$role) { ?>
            <a href="login.php" class="btn btn-outline">Login</a>
            <a href="register.php" class="btn btn-primary">Get Started</a>
        <?php } else { ?>
            <span>Hi, <?php echo htmlspecialchars($name); ?> 👋</span>
            <?php if ($role === 'student') { ?>
                <a href="student_dashboard.php" class="btn btn-primary">Dashboard</a>
            <?php } else { ?>
                <a href="expert_dashboard.php" class="btn btn-primary">Dashboard</a>
            <?php } ?>
            <a href="logout.php" class="btn btn-outline">Logout</a>
        <?php } ?>
    </div>
</div>

<!-- ABOUT -->
<section class="about" id="about">
    <h2 class="section-title">About TechTales</h2>
    <p class="section-sub">
        TechTales is a knowledge-sharing platform designed to bridge the gap between students
        and industry experts in the field of technology. Our goal is to create a 
        collaborative environment where learning goes beyond textbooks and connects
        directly with real-world experience.

In today’s fast-evolving technological landscape, students often struggle to keep up with emerging trends, while experts seek meaningful platforms to share their knowledge. TechTales brings both together under one roof.
    </p>
</section>

<!-- STORY -->
<section class="story" id="story">
    <h2 class="section-title">Our Journey</h2>

    <div class="story-grid">
        <div class="story-card">
            <h3>🌱 The Beginning</h3>
            <p>TechTales began to solve the lack of real mentorship.</p>
        </div>

        <div class="story-card">
            <h3>🤝 Bridging the Gap</h3>
            <p>Students and experts came together on one trusted platform.</p>
        </div>

        <div class="story-card">
            <h3>🚀 Growing Together</h3>
            <p>We are now a growing learning ecosystem.</p>
        </div>
    </div><br>

    <!-- LIVE STATS -->

    <section class="story" id="story">
    <h2 class="section-title">Live Stats</h2>
    <div class="story-stats">
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalUsers; ?>+</div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $totalExperts; ?>+</div>
            <div class="stat-label">Experts</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?php echo $totalStudents; ?>+</div>
            <div class="stat-label">Students</div>
        </div>
    </div>
</section>

<!-- WHY -->
<section class="why" id="why">
    <h2 class="section-title">Why Choose TechTales</h2>

    <div class="why-grid">
        <div class="why-card">🎓 Expert-written blogs</div>
        <div class="why-card">💬 Real interaction</div>
        <div class="why-card">📚 Practical learning</div>
        <div class="why-card">🌍 Community driven</div>
    </div>
</section>

<!-- mission--->
<section class="mission" id="mission">
    <h2 class="section-title">Our Mission</h2>

    <div class="mission-grid">
        <div class="mission-card">👨‍🎓 For Students

TechTales empowers students by providing:<br>

✅Access to expert-written blogs on latest technologies<br>

✅Opportunities to ask questions and clear doubts<br>

✅Exposure to real-world technical insights<br>

✅Continuous learning beyond classroom boundaries</div>
        <div class="mission-card">👩‍💻 For Experts

Experts play a vital role in the TechTales community. 
Through this platform, experts can:<br>

✅Publish blogs on modern technologies and trends<br>

✅Share professional experiences and best practices<br>

✅Answer student questions and guide learners<br>

Contribute to building a strong learning ecosystem</div>
        <div class="mission-card">🛠 Platform Features<br>

✅Role-based access for Students, Experts, and Admin<br>

✅Secure registration and login system<br>

✅Blog posting and reading functionality<br>

✅Question and answer interaction<br>


</section>

<!-- CTA -->
<section class="cta">
    <h2>Start Your Learning Journey</h2>
    <p>Join TechTales and grow with guidance that matters.</p>

    <?php if (!$role) { ?>
        <a href="register.php" class="btn btn-primary">Join Now</a>
    <?php } ?>
</section>

<!-- FOOTER -->
<div class="footer">
    © <?php echo date("Y"); ?> TechTales • Your Tech Xpert
</div>

</body>
</html>
