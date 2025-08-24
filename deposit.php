<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['username'];

$u = mysqli_query($conn, "SELECT id, balance FROM users WHERE username='$user'");
$me = mysqli_fetch_assoc($u);
$uid = $me ? $me['id'] : 0;
$balance = $me ? $me['balance'] : 0;

$iban = "JO" . substr(strval(($uid*9719)+10000000),0,2) . " NCSC " . substr(md5($user),0,4) . " " . substr(md5($user),4,4) . " " . substr(md5($user),8,4);

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amt = $_POST['amount'];
    mysqli_query($conn, "UPDATE users SET balance=balance+$amt WHERE username='$user'");
    mysqli_query($conn, "INSERT INTO transactions(user_id,amount,type) VALUES((SELECT id FROM users WHERE username='$user'),$amt,'deposit')");
    $r = mysqli_query($conn, "SELECT balance FROM users WHERE username='$user'");
    $me = mysqli_fetch_assoc($r);
    $balance = $me ? $me['balance'] : 0;
    $msg = "Deposit done";
}

$tx = mysqli_query($conn, "SELECT amount, type, created_at FROM transactions WHERE user_id=(SELECT id FROM users WHERE username='$user') ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Deposit</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto}
    nav.navbar{background:#0d47a1;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 18px}
    nav .links a{color:#fff;text-decoration:none;margin-right:10px;padding:6px 10px;border:1px solid #fff;border-radius:8px}
    nav .navbar-brand{display:flex;align-items:center;gap:10px}
    nav .navbar-brand img{height:40px}
    .hero{min-height:100vh;background:url('images/background.jpg') center/cover no-repeat fixed;display:flex;align-items:flex-start;justify-content:center;padding:56px 16px}
    .wrap{width:100%;max-width:960px;display:grid;grid-template-columns:1.3fr .7fr;gap:18px}
    .card{background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.12);padding:22px}
    .title{margin:0 0 8px;font-weight:700;text-align:left}
    .sub{margin:0;color:#444}
    .balance{font-size:15px;margin:6px 0 16px}
    .iban{font-family:monospace;background:#f5f7fb;padding:8px 10px;border-radius:10px;display:inline-block}
    .input{width:100%;padding:12px 14px;border:1px solid #d0d7de;border-radius:10px;font-size:16px;margin-top:10px}
    .row{display:flex;gap:10px;margin-top:10px}
    .btn{padding:12px 16px;background:#1565d8;color:#fff;border:0;border-radius:10px;cursor:pointer}
    .btn.full{width:100%}
    .chip{flex:1;background:#eef3ff;border:0;border-radius:10px;padding:10px 0;cursor:pointer}
    .alert{background:#e8fff3;color:#0a7;border:1px solid #bdf2d6;padding:10px 12px;border-radius:8px;margin-top:10px;text-align:center}
    table{width:100%;border-collapse:collapse;margin-top:8px}
    th,td{padding:10px 8px;border-bottom:1px solid #eee;text-align:left;font-size:14px}
    th{color:#555;background:#fafafa}
    .muted{color:#667}
    @media(max-width:900px){.wrap{grid-template-columns:1fr}}
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
  <div class="wrap">
    <div class="card">
      <h2 class="title">💰 Deposit</h2>
      <p class="sub">Account name: <b><?php echo htmlspecialchars($user); ?></b></p>
      <p class="balance">IBAN: <span class="iban"><?php echo $iban; ?></span></p>
      <p class="balance">Your balance: <b><?php echo number_format((float)$balance, 2); ?> JD</b></p>
      <?php if ($msg) { echo "<div class='alert'>$msg</div>"; } ?>
      <form method="POST">
        <input class="input" type="number" step="0.01" name="amount" placeholder="Amount (JD)" required>
        <div class="row">
          <button type="button" class="chip" onclick="document.querySelector('[name=amount]').value='10'">+10</button>
          <button type="button" class="chip" onclick="document.querySelector('[name=amount]').value='50'">+50</button>
          <button type="button" class="chip" onclick="document.querySelector('[name=amount]').value='100'">+100</button>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn full" type="submit">Deposit</button>
        </div>
      </form>
      <p class="muted" style="margin-top:10px">Processing time: instant • Currency: JD</p>
    </div>

    <div class="card">
      <h3 class="title">Recent activity</h3>
      <table>
        <tr><th>Type</th><th>Amount</th><th>Date</th></tr>
        <?php
        if ($tx && mysqli_num_rows($tx)>0) {
          while($r = mysqli_fetch_assoc($tx)) {
            $amt = number_format((float)$r['amount'],2);
            $type = strtoupper($r['type']);
            $dt = $r['created_at'] ? $r['created_at'] : date('Y-m-d H:i');
            echo "<tr><td>$type</td><td>$amt JD</td><td>$dt</td></tr>";
          }
        } else {
          echo "<tr><td colspan='3' class='muted'>No transactions yet</td></tr>";
        }
        ?>
      </table>
    </div>
  </div>
</section>

</body>
</html>
