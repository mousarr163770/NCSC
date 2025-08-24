<?php
include("config.php");

$results = [];
if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $query = "SELECT * FROM users WHERE username LIKE '%$q%'";
    $res = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($res)) {
        $results[] = $row['username'];
    }

    echo "<p>نتائج البحث عن: <b>" . $_GET['q'] . "</b></p>";
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>NCSC Bank - Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>🔍 البحث عن مستخدم</h2>
    <form method="GET">
        <input type="text" name="q" placeholder="ابحث عن اسم مستخدم">
        <button type="submit">بحث</button>
    </form>
    <?php if (!empty($results)) { ?>
        <ul>
            <?php foreach ($results as $user) { echo "<li>$user</li>"; } ?>
        </ul>
    <?php } ?>
</div>
</body>
</html>
