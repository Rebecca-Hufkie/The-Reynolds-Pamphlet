<?php 
session_start();
// Include your database connection
require_once 'toolkit/config.php';

// Define a variable to hold success or error messages
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['userId']; // Assuming user ID is fetched from session

    $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    // Check for connection errors
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Handle file upload
    if (!empty($_FILES['profilePic']['name'])) {  // Use 'profilePic' instead of 'upload'
        $targetDir = "wwroot/";
        $fileName = time() . basename($_FILES["profilePic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow only specific file formats
        $allowedTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowedTypes)) {
            // Move file to the server
            if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)) {
                // Update profilePic column in the users table for the current user
                $stmt = $mysqli->prepare("UPDATE users SET profilePic = ? WHERE UserID = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $targetFilePath, $userId);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        $message = "Profile changed successfully!";
                    } else {
                        $message = "Failed to update profile picture.";
                    }
                    $stmt->close();
                } else {
                    die("SQL error when preparing profile picture update: " . $mysqli->error);
                }
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        }
    } else {
        $message = "Please select a file to upload.";
    }
    
    // Close the database connection
    $mysqli->close();

    // Display the message and redirect
    if (!empty($message)) {
        echo "<script type='text/javascript'>
                alert('$message');
                window.location.href='User.php?alias=" . $_SESSION['alias'] . "';
              </script>";
        exit; // Ensure the script stops execution after redirection
    }
}
