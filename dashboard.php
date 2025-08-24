<?php
session_start();
include("config.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

$res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <div class="links">
    <a href="index.php">🏠 Home</a>
  </div>
  <div class="navbar-brand">
    <img src="https://ncsc.jo/ebv4.0/root_storage/ar/eb_homepage/microsoftteams-image_(283)_copy_copy.png" 
         alt="Bank Logo">
    <h1>Bank NCSC</h1>
  </div>
  <div class="links">
    <a href="logout.php">🚪 Logout</a>
  </div>
</nav>

<section class="hero">
  <div class="form-container">
    <h2>👋 Welcome, <?php echo $user['username']; ?>!</h2>
    <p>Your current balance: 💰 <b><?php echo number_format($user['balance'], 2); ?> JD</b></p>
  </div>
</section>

<section class="services">
  <div class="container">
    <h2>⚙️ Quick Actions</h2>
    <div class="service">
      <h3>💸 Transfer</h3>
      <p><a href="transfer.php">Send money to another account</a></p>
    </div>
    <div class="service">
      <h3>💰 Deposit</h3>
      <p><a href="deposit.php">Deposit money into your account</a></p>
    </div>
    <div class="service">
      <h3>📜 Transactions</h3>
      <p><a href="transactions.php">View your transaction history</a></p>
    </div>
    <div class="service">
      <h3>🔑 Change Password</h3>
      <p><a href="change_password.php">Update your password</a></p>
    </div>
  </div>
</section>

</body>
</html>
