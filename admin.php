<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Admin</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto}
    nav.navbar{background:#0d47a1;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 18px}
    nav .links a{color:#fff;text-decoration:none;margin-right:10px;padding:6px 10px;border:1px solid #fff;border-radius:8px}
    nav .navbar-brand{display:flex;align-items:center;gap:10px}
    nav .navbar-brand img{height:40px}
    .hero{min-height:100vh;background:url('images/background.jpg') center/cover no-repeat fixed;display:flex;align-items:center;justify-content:center;padding:56px 16px}
    .card{background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.12);padding:28px;width:100%;max-width:600px;text-align:center}
    .title{margin:0 0 12px;font-weight:700}
    .btns a{display:inline-block;margin:6px;padding:10px 16px;background:#1565d8;color:#fff;border-radius:10px;text-decoration:none}
    .btns a:hover{opacity:.9}
  </style>
</head>
<body>

<nav class="navbar">
  <div class="links">
    <a href="index.php">🏠 Home</a>
    <a href="dashboard.php">📊 Dashboard</a>
  </div>
  <div class="navbar-brand">
    <img src="https://ncsc.jo/ebv4.0/root_storage/ar/eb_homepage/microsoftteams-image_(283)_copy_copy.png" alt="Bank Logo">
    <h1 style="font-size:18px;margin:0;">Bank NCSC</h1>
  </div>
  <div class="links">
    <a href="logout.php">🚪 Logout</a>
  </div>
</nav>

<section class="hero">
  <div class="card">
    <h2 class="title">⚙️ Admin Panel</h2>
    <p>Welcome, <b><?php echo htmlspecialchars($user); ?></b></p>
    <div class="btns">
      <a href="upload.php">📂 Upload Center</a>
      <a href="transactions.php">📜 Transactions</a>
      <a href="users.php">👥 Manage Users</a>
    </div>
    <p style="margin-top:14px;color:#667">*Access not restricted → Broken Access Control vulnerability*</p>
  </div>
</section>

</body>
</html>
