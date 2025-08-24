<?php
session_start();
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE username='$username' 
              AND (password='$password' OR password=md5('$password'))";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        $_SESSION['balance'] = $user['balance'];

        $sid = md5(time() . rand());
        setcookie("NCSCSESSID", $sid, time()+3600, "/");

        $next = isset($_GET['redirect']) ? $_GET['redirect'] : "dashboard.php";
        header("Location: $next");
        exit;
    } else {
        $error = "❌ Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank NCSC - Login</title>
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
    <h2>🔑 Login</h2>
    <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="login.php<?php echo isset($_GET['redirect']) ? '?redirect='.urlencode($_GET['redirect']) : '' ; ?>">
      <input type="text" placeholder="Username" name="username" required>
      <input type="password" placeholder="Password" name="password" required>
      <button type="submit">Login</button>
    </form>
    <p style="margin-top:15px;">Don’t have an account? <a href="register.php">📝 Create Account</a></p>
  </div>
</section>

</body>
</html>
