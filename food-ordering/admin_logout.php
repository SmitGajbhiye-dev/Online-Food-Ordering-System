<?php
// ================================================================
// ADMIN LOGOUT (admin_logout.php)
// ================================================================
// Destroys admin session and logs out the admin user
// Redirects to admin login page
// ================================================================

// Start session
session_start();

// ================================================================
// DESTROY ADMIN SESSION
// ================================================================

// Unset all session variables related to admin
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_email']);

// Destroy the session completely
session_destroy();

// ================================================================
// REDIRECT TO ADMIN LOGIN PAGE
// ================================================================

header("Location: admin.php");
exit();
?>
