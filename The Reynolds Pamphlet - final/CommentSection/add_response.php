<?php
    // start session for user authentication and security
    require_once('../secure.php');
     
    $userId = $_SESSION['userId'];
    $commentid = $_POST['commentID'];
    $confessionid = $_POST['confessionID'];
    $response = $_POST['response'];
    //import config file
    require_once("../toolkit/config.php");
    //make a connection
    $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

                    
    if ($conne -> connect_error) {
        die("<p>Connection failed: Incorrect credentials</p>");
    }

    $sql = "insert into responses (confessionID, userID, responsetext, responseDate, commentId)
            values ( $confessionid , $userId , '$response' , now() , $commentid);" ;

    $confessions_results = $conne -> query($sql);

    if ($confessions_results === FALSE) {
        die("<p>Query Unsuccessful!</p>");
    }

    else{
        header("Location: commentSec.php?confessionid={$confessionid}");
        exit(); // Always exit after header redirect
    }

?>