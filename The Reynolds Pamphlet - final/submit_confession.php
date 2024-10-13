<?php
    // Start the session
    require_once("secure.php");

    // CSRF protection
    // if ($_POST['csrf_token']) {
    //     die("CSRF token validation failed.");
    // }

    // Get user session details
    $user_name = $_SESSION['userName'];
    $user_ID = $_SESSION['userId'];

    // Get database connection details
    require_once('toolkit/config.php');

    // Attempt to make database connection
    $connection = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    // Check if connection was successful
    if ($connection->connect_error) {
        error_log("Database connection error: " . $connection->connect_error);
        die("Database connection failed.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get category of confession
        $category = $_POST['category'];

        // Valid categories according to your ENUM definition
        $valid_categories = ['Love', 'Tea/Drama', 'Campus Scandals', 'Mental Health', ''];

        // Validate category
        if (!in_array($category, $valid_categories)) {
            die("Invalid category selected.");
        }

        // Get confession text
        $confession = trim($_POST['confession']);

        // Get userID and alias associated with username
        $user_alias_stmt = $connection->prepare("SELECT alias FROM users WHERE username = ?");
        $user_alias_stmt->bind_param('s', $user_name);
        $user_alias_stmt->execute();
        $user_alias_stmt_result = $user_alias_stmt->get_result();

        // Check if user exists
        if ($user_alias_stmt_result->num_rows === 0) {
            die("User does not exist!");
        }

        // Store userID and alias
        $user_info = $user_alias_stmt_result->fetch_assoc();
        $alias = $user_info['alias'];

        // Ensure that the confession is safe from special characters
        $secure_confession = htmlspecialchars($confession, ENT_QUOTES, 'UTF-8');

        // Create and bind query which inserts confession into database
        $confession_stmt = $connection->prepare("INSERT INTO confessions (userID, description, alias, category) VALUES (?, ?, ?, ?)");
        $confession_stmt->bind_param('isss', $user_ID, $secure_confession, $alias, $category);

        // Check if insert was successful
        if ($confession_stmt->execute()) {
            header("Location: make_confession.php?submitted_successfully=true");
            exit();
        } else {
            error_log("Database insertion error: " . $confession_stmt->error);
            die("Unable to insert confession into the database.");
        }
    }

    // close database connection
    $connection->close();
