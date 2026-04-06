<?php
session_start();

/* Destroy session */
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logged Out | TechTales</title>

<!-- AUTO REDIRECT AFTER 5 SECONDS -->
<meta http-equiv="refresh" content="5;url=login.php">

<style>
/* ===== RESET ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins','Segoe UI',sans-serif;
}

/* ===== BACKGROUND ===== */
body {
    min-height: 100vh;
    background: linear-gradient(
        135deg,
        #0f2027,
        #203a43,
        #2c5364,
        #1e3c72,
        #2a5298
    );
    background-size: 400% 400%;
    animation: bgMove 16s ease infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
}

@keyframes bgMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* ===== LOGOUT CARD ===== */
.logout-box {
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(18px);
    border-radius: 26px;
    padding: 45px 50px;
    text-align: center;
    box-shadow: 0 30px 60px rgba(0,0,0,0.45);
    animation: fadeUp 0.9s ease;
    max-width: 420px;
    width: 90%;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(35px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== ICON ===== */
.logout-icon {
    font-size: 56px;
    margin-bottom: 20px;
}

/* ===== TITLE ===== */
.logout-box h1 {
    font-size: 30px;
    margin-bottom: 10px;
    font-weight: 600;
}

/* ===== MESSAGE ===== */
.logout-box p {
    font-size: 15.5px;
    opacity: 0.9;
    margin-bottom: 28px;
    line-height: 1.6;
}

/* ===== BUTTONS ===== */
.btn-group {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 26px;
    border-radius: 28px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.35s ease;
}

/* Login button */
.btn-login {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: #ffffff;
    box-shadow: 0 12px 30px rgba(0,114,255,0.65);
}

.btn-login:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(0,114,255,0.9);
}

/* Home button */
.btn-home {
    border: 1px solid rgba(255,255,255,0.6);
    color: #ffffff;
}

.btn-home:hover {
    background: rgba(255,255,255,0.25);
}

/* ===== REDIRECT TEXT ===== */
.redirect-note {
    margin-top: 18px;
    font-size: 13px;
    opacity: 0.8;
}
</style>
</head>

<body>

<div class="logout-box">
    <div class="logout-icon">👋</div>

    <h1>You’re Logged Out</h1>

    <p>
        You have been logged out successfully.<br>
        Thank you for using <strong>TechTales</strong>.
    </p>

    <div class="btn-group">
        <a href="login.php" class="btn btn-login">Login Again</a>
        <a href="index.php" class="btn btn-home">Go to Home</a>
    </div>

    <div class="redirect-note">
        Redirecting you to login in 5 seconds…
    </div>
</div>

</body>
</html>
