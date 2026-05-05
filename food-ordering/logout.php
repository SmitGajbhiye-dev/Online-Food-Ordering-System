<?php
// ================================================================
// USER LOGOUT PAGE (logout.php)
// ================================================================
// Destroys user session and logs out the user
// Redirects to login page after logout
// ================================================================

// Start session to access session variables
session_start();

// ================================================================
// DESTROY SESSION
// ================================================================
// Unset all session variables
session_unset();

// Destroy the session completely
session_destroy();

// ================================================================
// REDIRECT TO LOGIN PAGE
// ================================================================
// Redirect user to login page after successful logout
header("Location: login.php");
exit();
?>
