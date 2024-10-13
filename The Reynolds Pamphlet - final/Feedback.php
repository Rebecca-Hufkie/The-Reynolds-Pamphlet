<?php
require_once("secure.php");
// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);


// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error variables
$nameErr = $emailErr = $feedbackErr = "";
$name = $email = $feedback = "";

// Validate form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        // Use htmlspecialchars to prevent XSS attacks
        $name = htmlspecialchars(trim($_POST["name"]), ENT_QUOTES, 'UTF-8');
    }

    // Validate and sanitize email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        // Filter email
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    }

    // Validate and sanitize feedback
    if (empty($_POST["feedback"])) {
        $feedbackErr = "Feedback is required";
    } else {
        // Use htmlspecialchars to sanitize the feedback
        $feedback = htmlspecialchars(trim($_POST["feedback"]), ENT_QUOTES, 'UTF-8');
    }

    // If there are no validation errors, proceed to save the data in the database
    if (empty($nameErr) && empty($emailErr) && empty($feedbackErr)) {
        $sql = "INSERT INTO feedback (Name, email, feedContent) VALUES ('$name', '$email', '$feedback')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Feedback Submitted Successfully!!!!');</script>";
            echo "<script>window.location.href = 'Feed.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Form validation errors: $nameErr $emailErr $feedbackErr";
    }
}

// Close the connection
$conn->close();



