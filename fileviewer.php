<?php
session_start();
include("config.php");
$user = $_SESSION['username'];

if(isset($_GET['file'])){
    $f = $_GET['file'];
    $path = "uploads/" . $f;
    if(file_exists($path)){
        $c = file_get_contents($path);
        echo "<pre>$c</pre>";
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
?>
