<?php
// logout.php
include('includes/config.php');
include('includes/auth.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = array();

// Destroy the session
if (session_destroy()) {
    // Start new session for success message
    session_start();
    $_SESSION['success'] = "You have been logged out successfully.";
}

// Redirect to login page
header("Location: login.php");
exit();
?>