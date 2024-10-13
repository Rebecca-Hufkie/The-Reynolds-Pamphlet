<?php
session_start();

// Check if the user does not have access or if their account status is not 'Active'
if (!isset($_SESSION['access']) || $_SESSION['accountStatus'] !== 'Active') {
    header("Location: Home.html");
    exit(); // Ensure no further code is executed after redirection
}

