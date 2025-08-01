<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page (change path if needed)
header("Location: student_login.php");
exit();
?>
