<?php
// Start the session
require_once("secure.php");

// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get the form inputs
    $newFirstName = mysqli_real_escape_string($conn, $_POST['First-name']);
    $newLastName = mysqli_real_escape_string($conn, $_POST['Last-name']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['user-email']);
    $newAlias = mysqli_real_escape_string($conn, $_POST['user-name']);
 
    // Track any changes
    $changes = false;

    // Check if first name changed
    if ($newFirstName !== $_SESSION['firstName']) {
        $_SESSION['firstName'] = $newFirstName; // Update session
        $stmt = $conn->prepare("UPDATE users SET firstName = ? WHERE UserID = ?");
        $stmt->bind_param("si", $newFirstName, $_SESSION['userId']);
        $stmt->execute();
        $changes = true;
    }

    // Check if last name changed
    if ($newLastName !== $_SESSION['lastName']) {
        $_SESSION['lastName'] = $newLastName; // Update session
        $stmt = $conn->prepare("UPDATE users SET lastName = ? WHERE UserID = ?");
        $stmt->bind_param("si", $newLastName, $_SESSION['userId']);
        $stmt->execute();
        $changes = true;
    }

    // Check if email changed
    if ($newEmail !== $_SESSION['email']) {
        $_SESSION['email'] = $newEmail; // Update session
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE UserID = ?");
        $stmt->bind_param("si", $newEmail, $_SESSION['userId']);
        $stmt->execute();
        $changes = true;
    }

    // Check if alias changed
    if ($newAlias !== $_SESSION['alias']) {
        $_SESSION['alias'] = $newAlias; // Update session
        $stmt = $conn->prepare("UPDATE users SET alias = ? WHERE UserID = ?");
        $stmt->bind_param("si", $newAlias, $_SESSION['userId']);
        $stmt->execute();

        // change alias for all confessions to new alias
        $confession_alias_change_sql = $conn->prepare("UPDATE confessions SET alias = ? WHERE userID = ?;");
        $confession_alias_change_sql->bind_param("si", $newAlias, $_SESSION['userId']);
        $confession_alias_change_sql->execute();
        $changes = true;
    }

    // Check if there were any changes
    if ($changes) {
        echo "<script>alert('Profile updated successfully.');</script>";
    } else {
        echo "<script>alert('No changes made.');</script>";
    }

    // Redirect or refresh the page
    echo "<script>window.location.href=User.php?alias={$_SESSION['alias']};</script>";
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
