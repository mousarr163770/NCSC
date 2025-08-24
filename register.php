<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pw = md5($password);
    $sql = "INSERT INTO users (username, password, balance) VALUES ('$username', '$pw', 0)";
    if (mysqli_query($conn, $sql)) {
        $success = "✅ Account created successfully! You can now login.";
    } else {
        $error = "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <div class="links"><a href="index.php">🏠 Home</a></div>
  <div class="navbar-brand">
    <img src="https://ncsc.jo/ebv4.0/root_storage/ar/eb_homepage/microsoftteams-image_(283)_copy_copy.png" alt="Bank Logo">
    <h1>Bank NCSC</h1>
  </div>
  <div class="links"></div>
</nav>

<section class="hero">
  <div class="form-container">
    <h2>📝 Create Account</h2>
    <?php if (!empty($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="register.php">
      <input type="text" placeholder="Username" name="username" required>
      <input type="password" placeholder="Password" name="password" required>
      <button type="submit">Register</button>
    </form>
    <p style="margin-top:15px;">Already have an account? <a href="login.php">🔑 Login</a></p>
  </div>
</section>

</body>
</html>
