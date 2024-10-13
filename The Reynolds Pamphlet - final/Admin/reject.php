<?php 
    session_start();
    // Import config file
    require_once("../toolkit/config.php");
    // Make a connection
    $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conne->connect_error) {
        die("<p>Connection failed: Incorrect credentials</p>");
    }

    // Check if 'id' is passed via GET for accepting a confession
    if (isset($_GET['id'])) {
        $confessionId = intval($_GET['id']); // Sanitize the id to prevent SQL injection

        // Update the confession status to 'Accepted'
        $update_sql = "UPDATE confessions SET status = 'Rejected' WHERE confessionID = ?";
        
        // Prepare and execute the query
        $stmt = $conne->prepare($update_sql);
        $stmt->bind_param("i", $confessionId);
        if ($stmt->execute()) {
            echo "<p>Status updated to 'Accepted' for confession ID: {$confessionId}</p>";
        } else {
            echo "<p>Failed to update status for confession ID: {$confessionId}</p>";
        }

        // Optionally, you can redirect back to the same page or a confirmation page
        header("Location: Myconfessions.php");
        exit();
    }
