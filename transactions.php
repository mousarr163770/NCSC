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

$q   = isset($_GET['q']) ? $_GET['q'] : "";
$from= isset($_GET['from']) ? $_GET['from'] : "";
$to  = isset($_GET['to']) ? $_GET['to'] : "";

$where = "user_id=$uid";
if ($q !== "") {
    $where .= " AND (type LIKE '%$q%' OR amount LIKE '%$q%')";
}
if ($from !== "") {
    $where .= " AND created_at >= '$from'";
}
if ($to !== "") {
    $where .= " AND created_at <= '$to'";
}

$sql = "SELECT id, type, amount, created_at FROM transactions WHERE $where ORDER BY id DESC LIMIT 100";
$tx  = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Transactions</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto}
    nav.navbar{background:#0d47a1;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 18px}
    nav .links a{color:#fff;text-decoration:none;margin-right:10px;padding:6px 10px;border:1px solid #fff;border-radius:8px}
    nav .navbar-brand{display:flex;align-items:center;gap:10px}
    nav .navbar-brand img{height:40px}
    .hero{min-height:100vh;background:url('images/background.jpg') center/cover no-repeat fixed;display:flex;align-items:flex-start;justify-content:center;padding:56px 16px}
    .wrap{width:100%;max-width:1100px;display:grid;grid-template-columns:1fr;gap:18px}
    .card{background:#fff;border-radius:16px;box-shadow:0 12px 30px rgba(0,0,0,.12);padding:22px}
    .head{display:flex;flex-wrap:wrap;align-items:center;gap:10px;justify-content:space-between}
    .balance{font-size:15px;color:#333}
    .filters{display:flex;flex-wrap:wrap;gap:10px;margin-top:12px}
    .input{padding:10px 12px;border:1px solid #d0d7de;border-radius:10px;font-size:14px}
    .btn{padding:10px 16px;background:#1565d8;color:#fff;border:0;border-radius:10px;cursor:pointer}
    table{width:100%;border-collapse:collapse;margin-top:14px}
    th,td{padding:12px 10px;border-bottom:1px solid #eee;text-align:left;font-size:14px}
    th{background:#fafafa;color:#555}
    .pill{display:inline-block;padding:4px 8px;border-radius:999px;font-size:12px}
    .pill.deposit{background:#e8fff3;color:#0a7;border:1px solid #bdf2d6}
    .pill.transfer{background:#fff3e8;color:#c76700;border:1px solid #f7d9b8}
    .muted{color:#667}
    .no-data{padding:16px;text-align:center;color:#667}
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
      <div class="head">
        <h2 style="margin:0">📜 Transactions</h2>
        <div class="balance">Current balance: <b><?php echo number_format((float)$balance,2); ?> JD</b></div>
      </div>

      <form class="filters" method="GET" action="transactions.php">
        <input class="input" type="text" name="q" value="<?php echo isset($_GET['q'])?$_GET['q']:""; ?>" placeholder="Search (type or amount)">
        <input class="input" type="date" name="from" value="<?php echo htmlspecialchars($from); ?>">
        <input class="input" type="date" name="to" value="<?php echo htmlspecialchars($to); ?>">
        <button class="btn" type="submit">Filter</button>
        <a class="btn" href="transactions.php">Reset</a>
      </form>

      <?php if ($q !== "") { echo "<div class='search-tag'>Showing results for: <b>$q</b></div>"; } ?>

      <table>
        <tr><th>ID</th><th>Type</th><th>Amount</th><th>Date</th></tr>
        <?php
        if ($tx && mysqli_num_rows($tx)>0) {
          while($r = mysqli_fetch_assoc($tx)) {
            $id = $r['id'];
            $type = strtolower($r['type']);
            $pill = $type === 'deposit' ? 'deposit' : 'transfer';
            $amt = number_format((float)$r['amount'],2);
            $dt = $r['created_at'] ? $r['created_at'] : date('Y-m-d H:i');
            echo "<tr>
                    <td>#$id</td>
                    <td><span class='pill $pill'>".strtoupper($type)."</span></td>
                    <td>$amt JD</td>
                    <td>$dt</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4' class='no-data'>No transactions found</td></tr>";
        }
        ?>
      </table>
      <p class="muted" style="margin-top:10px">Max 100 latest transactions are shown.</p>
    </div>
  </div>
</section>

</body>
</html>
