<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['username'];

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new = $_POST['new_password'];
    mysqli_query($conn, "UPDATE users SET password='$new' WHERE username='$user'");
    $msg = "Password changed";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Change Password</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto}
    nav.navbar{background:#0d47a1;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 18px}
    nav .links a{color:#fff;text-decoration:none;margin-right:10px;padding:6px 10px;border:1px solid #fff;border-radius:8px}
    nav .navbar-brand{display:flex;align-items:center;gap:10px}
    nav .navbar-brand img{height:40px}
    .hero{min-height:100vh;background:url('images/background.jpg') center/cover no-repeat fixed;display:flex;align-items:center;justify-content:center;padding:56px 16px}
    .card{width:100%;max-width:520px;background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.12);padding:24px}
    h2{margin:0 0 8px;text-align:center}
    .sub{margin:0 0 16px;text-align:center;color:#555}
    .input{width:100%;padding:12px 14px;border:1px solid #d0d7de;border-radius:10px;font-size:16px;margin-bottom:12px}
    .btn{width:100%;padding:12px 16px;background:#1565d8;color:#fff;border:0;border-radius:10px;font-size:16px;cursor:pointer}
    .btn:hover{opacity:.95}
    .alert{background:#e8fff3;color:#0a7;border:1px solid #bdf2d6;padding:10px 12px;border-radius:8px;margin-bottom:12px;text-align:center}
    .hint{font-size:13px;color:#667;text-align:center;margin-top:8px}
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
    <h2>🔑 Change Password</h2>
    <p class="sub">User: <b><?php echo htmlspecialchars($user); ?></b></p>
    <?php if ($msg) { echo "<div class='alert'>$msg</div>"; } ?>
    <form method="POST">
      <input class="input" type="password" name="new_password" placeholder="New Password" required>
      <button class="btn" type="submit">Change</button>
    </form>
    <p class="hint">After changing, use the new password to sign in.</p>
  </div>
</section>

</body>
</html>
