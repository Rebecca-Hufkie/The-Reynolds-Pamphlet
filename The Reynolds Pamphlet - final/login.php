<?php
// Start the session
session_start();

// Set access SESSION variable
$_SESSION['access'] = true;

// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form inputs and escape them using mysqli_real_escape_string
$user = mysqli_real_escape_string($conn, $_REQUEST["username"]);
$enteredPass = mysqli_real_escape_string($conn, $_REQUEST["password2"]); // Escaping and hashing the password

// Prepare the SQL statement to select by username only
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

// Bind the escaped parameter (username)
$stmt->bind_param("s", $user);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching user was found
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
   
    $salt = $row['salt']; // Password from the database
    $dbPassword = $row['password']  ;
    // Check if the hashed password matches
    if ($dbPassword === sha1($enteredPass . $salt)) {
        // Set session variables
        $_SESSION['role'] = $row['role'];
        $_SESSION['userId'] = $row['UserID'];
        $_SESSION['userName'] = $row['username'];
        $_SESSION['accountStatus'] = $row['accountStatus'];
        $_SESSION['profilePic'] = $row['profilePic'];

        // Check account status before redirecting based on role
        if ($_SESSION['accountStatus'] === 'Active') {
            // Redirect based on user role
            if ($_SESSION['role'] == 'Admin') {
                header("Location: Admin/MyConfessions.php");
                exit();
            } else if ($_SESSION['role'] == 'Confesser') {
                header("Location: confessions.php");
                exit();
            }
        } else if ($_SESSION['accountStatus'] === 'Deactivated') {
            echo "<script>
            alert('Your account is deactivated.');
            window.location.href = 'deDisplay.php';
        </script>";
        exit(); // Ensure no further code is executed

        } else {
            // Handle other account statuses
            $message = $_SESSION['accountStatus'] === 'Banned' 
                ? 'Your account has been banned. Please contact support.' 
                : 'You have been kicked out. Please contact support.';
            echo "<script>alert('$message');</script>";
            echo "<script>window.location.href = 'Home.html';</script>";
            exit();
        }
    } else {
        // Incorrect password
        echo "<script>alert('Incorrect password!');</script>";
    }
} else {
    // User not found
    echo "<script>alert('User not Found!');</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!-- HTML part
<p>
    <button class="custom-button" id="delete-account" 
            onclick="checkAccountStatus();">
        Deactivate Account
    </button>
</p>

<script>
function checkAccountStatus() {
    var accountStatus = "<?php echo $_SESSION['accountStatus']; ?>";

    if (accountStatus === 'active') {
        if (confirm('Are you sure you want to deactivate your account?')) {
            window.location.href = 'deactivate_account.php'; // Redirect to the deactivation script
        }
    } else {
        let message = accountStatus === 'banned' 
            ? 'Your account has been banned. Please contact support.' 
            : 'You have been kicked out. Please contact support.';
        alert(message);
    }
}
</script> -->
