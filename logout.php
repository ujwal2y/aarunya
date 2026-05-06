<?php
/**
 * Logout Handler
 * Handles logout for both users and admins
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session data
session_unset();
session_destroy();

// Start a new clean session
session_start();
session_regenerate_id(true);

// Redirect to login page
header('Location: client/login.php');
exit();
?>