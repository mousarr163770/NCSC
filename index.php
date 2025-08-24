<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
if (isset($_GET['msg'])) {
    echo "<div class='alert alert-info text-center' role='alert' style='margin:0;'>" . $_GET['msg'] . "</div>";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0d47a1;">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div>
      <a href="index.php" class="btn btn-sm btn-outline-light me-2">🏠 Home</a>
      <a href="login.php" class="btn btn-sm btn-outline-light me-2">🔑 Login</a>
      <a href="register.php" class="btn btn-sm btn-outline-light">📝 Register</a>
    </div>
    <a class="navbar-brand mx-auto d-flex align-items-center" href="index.php">
      <img src="https://ncsc.jo/ebv4.0/root_storage/ar/eb_homepage/microsoftteams-image_(283)_copy_copy.png" 
           alt="Bank Logo" style="height: 50px; margin-right:10px;">
      <span class="fw-bold fs-4">Bank NCSC</span>
    </a>
    <div></div>
  </div>
</nav>

<header class="hero text-center text-white d-flex align-items-center justify-content-center">
  <div>
    <h1 class="fw-bold">Welcome to Bank NCSC</h1>
    <p>Security, Speed, and Reliability for all your transactions</p>
    <a href="#services" class="btn btn-primary btn-lg">Discover Our Services</a>
  </div>
</header>

<section id="services" class="services py-5">
  <div class="container">
    <h2 class="mb-4 text-center">💼 Our Services</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="service p-3 shadow rounded bg-white text-center">
          <h3>💸 Money Transfer</h3>
          <p>Fast and secure money transfers worldwide.</p>
          <a href="transfer.php" class="btn btn-outline-primary btn-sm">Start Transfer</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service p-3 shadow rounded bg-white text-center">
          <h3>💰 Deposits</h3>
          <p>Deposit your money easily and safely.</p>
          <a href="deposit.php" class="btn btn-outline-primary btn-sm">Make a Deposit</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service p-3 shadow rounded bg-white text-center">
          <h3>🔍 Search Users</h3>
          <p>Look up users and basic information.</p>
          <a href="search.php" class="btn btn-outline-primary btn-sm">Search Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="text-center py-4">
  <small>&copy; <?php echo date('Y'); ?> Bank NCSC. All rights reserved.</small>
</footer>

</body>
</html>
