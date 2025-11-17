<?php
// database.php - MySQLi connection for Bislig admin
$host = 'localhost';
$db   = 'bislig_db'; // Change to your actual database name
$user = 'root'; // Change if needed
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
