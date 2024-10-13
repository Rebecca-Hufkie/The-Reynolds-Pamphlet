<?php
    // start session for user authentication and security
    require_once('secure.php');
     
    $userId = $_SESSION['userId'];
    $confessionid =  $_REQUEST['confessionid'];
    //import config file
    require_once("toolkit/config.php");
    //make a connection
    $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

                    
    if ($conne -> connect_error) {
        die("<p>Connection failed: Incorrect credentials</p>");
    }

    $sql = "DELETE FROM responses WHERE ConfessionID = '$confessionid'; " ;

    $confessions_results = $conne -> query($sql);

    if ($confessions_results === FALSE) {
        die("<p>Query to delete response failed!</p>");
    }


    $sql = "DELETE FROM comment WHERE ConfessionID = '$confessionid'; " ;

    $confessions_results = $conne -> query($sql);

    if ($confessions_results === FALSE) {
        die("<p>Query to delete comments failed!</p>");
    }

    $sql = "DELETE FROM confessions WHERE ConfessionID = '$confessionid'; " ;

    $confessions_results = $conne -> query($sql);

    if ($confessions_results === FALSE) {
        die("<p>Query to delete confession failed!</p>");
    }

    else{
        header("Location: Admin/AllConfessions.php");
        exit(); // Always exit after header redirect
    }




  

?>