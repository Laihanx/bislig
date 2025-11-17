<?php
// logout.php - Destroy session and redirect to login
session_start();
session_unset();
session_destroy();
header('Location: admin.php?loggedout=1');
exit;
?>
