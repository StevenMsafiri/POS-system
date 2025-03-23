<?php
define('DB_NAME', 'pos_system');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
