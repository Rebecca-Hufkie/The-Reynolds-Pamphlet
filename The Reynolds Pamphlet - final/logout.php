<?php
// Start the session
require_once("secure.php");

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Display the alert
echo "<script>alert('Sad to see you leave!!');</script>";

// Redirect after displaying the alert
// Use JavaScript for the redirect after showing the alert
echo "<script>window.location.href = 'Home.html';</script>";

// Prevent further execution of the script
exit();

