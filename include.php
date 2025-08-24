<?php
if(isset($_GET['page'])){
    $p = $_GET['page'];
    $file = $p . ".php";
    if(file_exists($file)){
        include($file);
    } else {
        echo "Page not found.";
    }
} else {
    echo "No page.";
}
