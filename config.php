<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ncsc_bank";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['debug'])) {
    echo "<!-- DEBUG: Connected to DB $db with user $user -->";
}
?>
