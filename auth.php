<?php
// auth.php
session_start();

// Regenerate session ID on each request to prevent session fixation
session_regenerate_id(true);

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}
?>
