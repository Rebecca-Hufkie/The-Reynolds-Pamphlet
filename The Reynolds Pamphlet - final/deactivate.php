<?php
    session_start();
    // start session for user authentication and security
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
$updateStmt = $conn->prepare("UPDATE users SET accountStatus = 'Deactivated' WHERE UserID = ?");

// Check if prepare was successful
if (!$updateStmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the userId parameter from session
$updateStmt->bind_param("i", $_SESSION['userId']);

// Execute the statement and check for success
if ($updateStmt->execute()) {
    echo "<script>alert(\'Account successfully deactivated.\');</script>";




} else {
    die("Error updating record: " . $updateStmt->error);
}

// Close the statement and connection
$updateStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    <title>Deactivated</title>
</head>
<body style="background-color:#ECD6FF;">
    <h1 style="text-align:center; padding: 150px; color:#EA638C; " class="playwrite-cu">You have been deactivated</h1>
    <a href="reactivate.php"><button class="custom-button" style="margin: 0px 50px 250px 400px">Reactivate</button></a>
</body>
</html>
