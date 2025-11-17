<?php
// insert_admin.php - Insert default admin user
include 'database.php';

$username = 'admin';
$password = 'admin123';
$email = 'admin@gmail.com';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sss", $username, $password_hash, $email);
    if (mysqli_stmt_execute($stmt)) {
        echo "Admin user inserted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Database error: " . mysqli_error($conn);
}
?>
