<?php


// Get the form inputs
$name = $_REQUEST["Name"];
$lname = $_REQUEST["LastName"];
$email = $_REQUEST["email"];
$user = $_REQUEST["user"];
$alias = $_REQUEST["alias"];
$pass = $_REQUEST["password"];
$salt = $_REQUEST["salt"];
$role = 'Confesser'; // Static role value

// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape the inputs using mysqli_real_escape_string
$name = mysqli_real_escape_string($conn, $name);
$lname = mysqli_real_escape_string($conn, $lname);
$email = mysqli_real_escape_string($conn, $email);
$user = mysqli_real_escape_string($conn, $user);
$alias = mysqli_real_escape_string($conn, $alias);
$pass = mysqli_real_escape_string($conn, $pass);

// Hash the password (consider using password_hash instead of sha1 for stronger security)
$pass = $pass . $salt; 
$pass = sha1($pass);

// Prepare the SQL statement using placeholders
$sql = "INSERT INTO users (username, password, role, firstName, lastName, email, alias, salt) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Initialize prepared statement
$stmt = $conn->prepare($sql);

// Bind the parameters ("sssssss" stands for seven string parameters)
$stmt->bind_param("ssssssss", $user, $pass, $role, $name, $lname, $email, $alias, $salt);

// Execute the query and check if it's successful
if ($stmt->execute()) {
    echo "<script>alert(' Welcome, $name! You have created an account successfully.');</script>";
    echo "<script>window.location.href='Home.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
