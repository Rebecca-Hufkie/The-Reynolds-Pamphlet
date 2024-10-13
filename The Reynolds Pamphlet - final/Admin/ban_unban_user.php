<?php
    // ensure user logs in first
    require_once("secure.php");

    // get database connection details and create connection
    require_once("../toolkit/config.php"); 
    $connection = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }   

    // check if form has been submitted to ban or unban a user
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Validate user ID
        if (isset($_POST['user_id']) && filter_var($_POST['user_id'], FILTER_VALIDATE_INT)) {
            $user_id = $_POST['user_id'];
        } else {
            die("Invalid user ID.");
        }

        // check if ban button was clicked
        if (isset($_POST['ban_user'])) {
            // set status to banned
            $status = "Banned";

            // prepare and bind query to change user status to banned
            $ban_user_stmt = $connection->prepare("UPDATE users SET accountStatus = ? WHERE UserID = ?;");
            $ban_user_stmt->bind_param("si", $status, $user_id);

            // check if banned sql executed successfully execute and get results of query
            if ($ban_user_stmt->execute()) {
                header("Location: admin.php");
            }
            $ban_user_stmt->close();
        }

        // check if unban button was clicked
        if (isset($_POST['unban_user'])) {
            // set status to active
            $status = "Active";

            // prepare and bind query to change user status to active
            $unban_user_stmt = $connection->prepare("UPDATE users SET accountStatus = ? WHERE UserID = ?;");
            $unban_user_stmt->bind_param("si", $status, $user_id);

            // check if unbanned sql executed successfully
            if ($unban_user_stmt->execute()) {
                header("Location: admin.php");
            }
            $unban_user_stmt->close();
        }
    }

    // close connection
    $connection->close();
