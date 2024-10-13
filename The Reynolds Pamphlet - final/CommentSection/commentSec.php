<?php
    // start session for user authentication and security
    require_once('../secure.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="commentSec.css" />
    <link rel="stylesheet" href="../CSS/styles.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    <script src="commentSec.js"></script>
</head>
<body>
<style>
    /* Sliding Side Panel */
    .side-panel {
        height: 100%;
        width: 0px;
        position: fixed;
        z-index: 999;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow-x: hidden;
        transition: 0.5s;
        transition-timing-function: ease;
    }

    .side-panel a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 25px;
        color: black;
        display: block;
        transition: 0.5s;
        transition-timing-function: ease;
    }

    /* Styling for the top and bottom sections */
    .top-links {
      position: absolute;
      top: 20px; /* Distance from the top */
    }

    .bottom-links {
      position: absolute;
      bottom: 20px; /* Distance from the bottom */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-left: 50px;
    }

    .top-links a:hover {
        background-color: #ffd8e3;
    }

    .side-panel a:hover {
        background-color: #ffd8e3;
    }

    .side-panel .close-btn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        display: block;
    }

    .open-btn {
        font-size: 20px;
        cursor: pointer;
        background-color: white;
        color: black;
        padding: 5px 10px;
        border: none;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 30px;  /* Adjusted to be closer */
        z-index: 1000;
    }

    .open-btn:hover {
        background-color: #ffff;
    }

    /* Adjusting content to shift when side panel is open */
    .main-content {
        transition: margin-left 0.5s;
    }

    @media (max-width: 768px) {

    .playwrite-cu {
      font-size: small;
    }

    .right-bar li {
    margin-right: 0px;
  }


}


    .header-panel {
    position: fixed; /* Makes the header stick to the top */
    top: 0;
    left: 0;
    width: 100%; /* Ensures the header spans the full width */
    padding: 10px 0 10px 85px; /* Reduced left padding */
    /* background: white;  Transparent background initially */
    color: #000000; /* Text color */
    display: inline-flex; /* Centers and aligns the header items */
    align-items: center; /* Vertically aligns items */
    z-index: 100; /* Ensures the header stays above other elements */
    transition: background-color 0.3s ease; /* Smooth background color change */
    background: white;
  }

    /* Title style */
    .header-panel h1 {
        font-family: 'Playwrite CU', cursive;
        margin: 0;
    }

    /* Navigation and right-side elements */
    .right-bar ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        right: 15px;
        overflow: hidden;
    }

    .right-bar ul li {
        margin-left: 15px;
    }

</style>
    <!-- Sliding Side Panel -->
    <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
        <a href="../confessions.php"><i class="fa-solid fa-home"></i> Home</a>
        <a href="../MyConfessions.php"><i class="fa-solid fa-book"></i> My Confessions</a>
        <a href="../make_confession.php"><i class="fa-solid fa-pen-to-square"></i> Make Confessions</a>
        <a href="../faq.html"><i class="fa-solid fa-question-circle"></i> FAQs</a>
        <a href="../Feed.php"><i class="fa-solid fa-comments"></i> Feedback</a>
        <a href="../user.php"><i class="fa-solid fa-user"></i> Profile</a>
    </div>

    <div class = "bottom-links">
        <a href="../logout.php"><button class="custom-button" id="logoutButton">Log out</button></a>
    </div>
    </div>

    <!-- Header with the Side Panel Button -->
    <div class="header-panel" >
    <a href="javascript:void(0)" class="open-btn" onclick="myFunction()"><i class="fa-solid fa-bars" style="font-size: 30px;"></i></a>
        <h1 class="playwrite-cu">The Reynolds Pamphlet</h1>
    </div>

    <?php 
        $confessionid =  $_REQUEST['confessionid'];

        //import config file
        require_once("../toolkit/config.php");
        //make a connection
        $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

                    
        if ($conne -> connect_error) {
            die("<p>Connection failed: Incorrect credentials</p>");
        }

        $sql = "SELECT * FROM confessions where confessionID = $confessionid";

        $confessions_results = $conne -> query($sql);

        if ($confessions_results === FALSE) {
            die("<p>Query Unsuccessful!</p>");
        }

        $confession =  $confessions_results -> fetch_assoc();
    ?>

    <div class="main-content">

<div class="comment-list">
    <!-- Profile Card in the Sidebar -->

    <?php 

        $cardColor = '';

        switch($confession['category']) {
            case 'Love':
                $cardColor = 'style= "background-color: #ea638c; margin: 0px;"'; break;
            case 'Tea/Drama':
                $cardColor = 'style= "background-color: #6f6194 ; margin: 0px;"'; break;
            case 'Campus Scandals':
                $cardColor = 'style= "background-color: #ecd6ff; margin: 0px;"'; break;
            case 'Mental Health':
                $cardColor = 'style= "background-color: #b8d9e0; margin: 0px;"'; break;
            default:
                $cardColor = 'style="background-color: #ffd8e3"';      
        }


        echo "<a href= '../confessions.php' class='card-item' {$cardColor} >";
        echo "<span class='developer'>{$confession['alias']}</span>";
        echo "<h3>{$confession['description']}</h3>";
        echo "</a>";
    ?>
    <!-- Comment Section -->
    <div class="comment-section">

        <?php 

            
            $sql = "SELECT * FROM comment join users on comment.commentUserID = users.UserID where confessionID = $confessionid";
            
            $comment_results = $conne -> query($sql);
            
            if ($comment_results === FALSE) {
                die("<p>Query Unsuccessful!</p>");
            }
            
            $commentNum = $comment_results -> num_rows;
           
            echo "<h2 class='comment-header'>Comments ({$commentNum})</h2>";
            $index = 0;
            if($commentNum > 0){
                while( $comment =  $comment_results -> fetch_assoc()){

                    $commentid = $comment['commentId'];
                    $sql = "SELECT * FROM responses join users on responses.userID = users.userID where commentId = $commentid;";
                    $response_results = $conne -> query($sql);

                    echo "<div class='comment'>";
                    echo "<div class='comment-author'> {$comment['alias']} <span id = 'time'>{$comment['commentDate']}</span></div>";
                    echo "<div class='comment-body'>{$comment['content']}</div>";
                    echo "<div class='interaction-bar'>";
                    echo "<button class='reply-btn' onclick='toggleReply({$index});'>Replies</button>";
                    echo "</div>";
                    echo "<div class='reply-form'  id='reply-{$index}'>";

                    while($response = $response_results -> fetch_assoc()){
                        echo "<div class='comment'>";
                        echo "<div class='comment-author'> {$response['alias']} <span id = 'time'>{$response['responseDate']}</span></div>";
                        echo "<div class='comment-body'>{$response['responseText']}</div>";
                        echo "</div>";
                    }
                    echo "<form action='add_response.php' method='post'>";
                    echo "<textarea  name='response'class='comment-input' placeholder='Add a reply...' required ></textarea>";
                    echo  "<input type='hidden' name='confessionID' value={$comment['confessionID']} >";
                    echo  "<input type='hidden' name='commentID' value= {$comment['commentId']} >";
                    echo "<button type='submit' value='Submit' class='submit-btn'>Submit</button>";
                    echo " </form>";
                    echo "</div>";
                    echo "</div>";
                    $index++;
                }
            }   
            else{
                echo "<h2> No Comments Available </h2>";
            }
        ?>

        <form action='add_comments.php' method='post'>
        <textarea  name='comment' class="comment-input" placeholder="Add comment..." required></textarea>
        <input type="hidden" name="confessionID" value= <?php echo $confessionid ?> >
        <button type='submit' value='Submit' class="submit-btn">Submit</button>
        </form>


    </div>
</div>
    </div>

<script>
        // JavaScript to open and close the side panel
        function myFunction() {
            var x = document.getElementById("mySidePanel");
            if (x.style.display === "block") {
                x.style.display = "none";
                closePanel();
            } else {
                x.style.display = "block";
                openPanel(); 
            }
        }
            
        function openPanel() {
            document.getElementById("mySidePanel").style.width = "250px";
            document.querySelector('.main-content').style.marginLeft = "250px";
            document.querySelector('.header-panel').style.marginLeft = "250px";
        }    
        

        function closePanel() {
            document.getElementById("mySidePanel").style.width = "0";
            document.querySelector('.main-content').style.marginLeft = "0";
            document.querySelector('.header-panel').style.marginLeft = "0";
        }
    </script>


</body>
</html>
