<?php
    // start session for user authentication and security
    session_start();
    if (!isset($_SESSION['access']) || ($_SESSION['accountStatus'] !== 'Deactivated' && $_SESSION['accountStatus'] !== 'Active')) {
        header("Location: Home.html");
        exit(); // Ensure no further code is executed after redirection
    }

// Check if userId exists in session
if (!isset($_SESSION['userId'])) {
    die("UserID is not set in the session. Please log in first.");
}

// Set access SESSION variable
$_SESSION['access'] = true;

// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the update query
$updateStmt = $conn->prepare("UPDATE users SET accountStatus = 'Active' WHERE UserID = ?");

// Check if prepare was successful
if (!$updateStmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the userId parameter from session
$updateStmt->bind_param("i", $_SESSION['userId']);

// Execute the statement and check for success
if ($updateStmt->execute()) {
    session_unset();

// Destroy the session
    session_destroy();
    echo "<script>alert('Account successfully reactivated! Please login again.');</script>";
    echo "<script>window.location.href = 'Home.html';</script>";

} else {
    die("Error updating record: " . $updateStmt->error);
}

// Close the statement and connection
$updateStmt->close();
$conn->close();
?>