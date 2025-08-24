<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['username'];

$u = mysqli_query($conn, "SELECT balance FROM users WHERE username='$user'");
$me = mysqli_fetch_assoc($u);
$balance = $me ? $me['balance'] : 0;

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to  = $_POST['to'];
    $amt = $_POST['amount'];

    mysqli_query($conn, "UPDATE users SET balance=balance-$amt WHERE username='$user'");
    mysqli_query($conn, "UPDATE users SET balance=balance+$amt WHERE username='$to'");
    mysqli_query($conn, "INSERT INTO transactions(user_id,amount,type) VALUES((SELECT id FROM users WHERE username='$user'),$amt,'transfer')");
    mysqli_query($conn, "INSERT INTO transactions(user_id,amount,type) VALUES((SELECT id FROM users WHERE username='$to'),$amt,'receive')");

    $r = mysqli_query($conn, "SELECT balance FROM users WHERE username='$user'");
    $me = mysqli_fetch_assoc($r);
    $balance = $me ? $me['balance'] : 0;

    $msg = "Transfer to $to done";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Transfer</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body{margin:0}
    nav.navbar{background:#0d47a1;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 18px}
    nav .links a{color:#fff;text-decoration:none;margin-right:10px;padding:6px 10px;border:1px solid #fff;border-radius:8px}
    nav .navbar-brand{display:flex;align-items:center;gap:10px}
    nav .navbar-brand img{height:40px}
    .hero-transfer{min-height:100vh;background:url('images/background.jpg') center/cover no-repeat fixed;display:flex;align-items:center;justify-content:center;padding:40px 16px}
    .card{width:100%;max-width:560px;background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.15);padding:28px}
    .title{margin:0 0 6px;text-align:center}
    .balance{margin:0 0 16px;text-align:center;color:#333}
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

<section class="hero-transfer">
  <div class="card">
    <h2 class="title">💸 Transfer</h2>
    <p class="balance">Your balance: <b><?php echo number_format((float)$balance, 2); ?> JD</b></p>
    <?php if ($msg) { echo "<div class='alert'>$msg</div>"; } ?>
    <form method="POST">
      <input class="input" type="text" name="to" placeholder="Recipient username / account" required>
      <input class="input" type="number" step="0.01" name="amount" placeholder="Amount" required>
      <button class="btn" type="submit">Transfer</button>
    </form>
    <div class="hint">User: <?php echo htmlspecialchars($user); ?></div>
  </div>
</section>

</body>
</html>
