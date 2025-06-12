<?php
// Start the session to access session variables
session_start();

// Destroy the session to log out the user
session_unset();  // Clear all session variables
session_destroy();  // Destroy the session

// Redirect to the home page after logout
header("Location: home.html");
exit();  // Ensure no further code is executed after redirection
?>
