<?php
 // Start the session
 require_once("secure.php");

if ($_SESSION['role'] != "Confesser"){
    header("Location: Home.html");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height,minimum-scale=1.0, initial-scale=1.0">
    <title>The Reynolds Pamphlet</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
</head>

</head>
<body style="background-color: aliceblue;">

    <!-- Sliding Side Panel -->
    <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
        <a href="confessions.php"><i class="fa-solid fa-home"></i> Home</a>
        <a href="make_confession.php"><i class="fa-solid fa-pen-to-square"></i> Make Confessions</a>
        <a href="faq.html"><i class="fa-solid fa-question-circle"></i> FAQs</a>
        <a href="Feed.php"><i class="fa-solid fa-comments"></i> Feedback</a>
        <a href="user.php"><i class="fa-solid fa-user"></i> Profile</a>
    </div>

    <div class = "bottom-links">
        <a href="logout.php"><button class="custom-button" id="logoutButton">Log out</button></a>
    </div>
    </div>

    <!-- Header with the Side Panel Button -->
    <div class="header-panel" >
    <a href="javascript:void(0)" class="open-btn" onclick="myFunction()"><i class="fa-solid fa-bars" style="font-size: 30px;"></i></a>
        <h1 class="playwrite-cu">The Reynolds Pamphlet</h1>
    </div>

    <div class="main-content">
    <!-- Main Content -->
        <main>
            <!-- Rest of your content goes here -->
            <section class="home" id="home">
            <h1 class="playwrite-cu" style="text-align: center; font-size: 3em;">My Confessions</h1>
                <a href="make_confession.php" class="icon-link">
                    <div id="pink-button" class="floating-button">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                </a>
                <div class="card-list">
                    <!-- PHP and dynamic content -->
                    <?php 
                    //import config file
                    require_once("toolkit/config.php");
                    //make a connection
                    $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

                    $user_id = $_SESSION['userId'];

            
                    if ($conne -> connect_error) {
                        die("<p>Connection failed: Incorrect credentials</p>");
                    }

                    $sql = "SELECT * FROM confessions Where userID = ?";


                    $stmt = $conne->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result === FALSE) {
                        die("<p>Query Unsuccessful!</p>");
                    }


                    // Display the confessions
                    while($confession =  $result->fetch_assoc()) {

                        $cardColor = '';

                        switch($confession['category']) {
                            case 'Love':
                                $cardColor = 'style= "background-color: #ea638c;"'; break;
                            case 'Tea/Drama':
                                $cardColor = 'style= "background-color: #6f6194 ;"'; break;
                            case 'Campus Scandals':
                                $cardColor = 'style= "background-color: #ecd6ff;"'; break;
                            case 'Mental Health':
                                $cardColor = 'style= "background-color: #b8d9e0;"'; break;
                            default:
                                $cardColor = 'style="background-color: #ffd8e3"';      
                        }

                        echo "<a href='CommentSection/commentSec.php?confessionid={$confession['confessionID']}' class='card-item' {$cardColor}>";
                        echo "<span class= 'developer'>{$confession['alias']}</span>";
                        echo "<h3>{$confession['description']}</h3>";
                    }
                ?>    
                
                </div>
            </section>  
        </main>
    </div>

    <footer>
        <div class="item">
        <p>
            <h4><p class="playwrite-cu">The Reynolds Pamphlet</p> &copy;2024 | Contact Us on GitHub: <a href="https://github.com/Wakag/Gears-of-Miracles" style=" color: #944a8a;">Gears-of-Miracles</a></h4>
        </p>
        </div>
        <div class="item">
            
            <table style="align-items: right;">
                <tr><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram fa-2x">&nbsp;&nbsp;</i></a></tr>
                <tr><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook fa-2x">&nbsp;&nbsp;</i></a></tr>
                <tr><a href="https://www.tiktok.com/explore"><i class="fa-brands fa-tiktok fa-2x">&nbsp;&nbsp;</i></a></tr>
                <tr><a href="https://youtu.be/x_MQRNkRaUE?si=6zN4suQm9a3nL4y1"><i class="fa-brands fa-youtube fa-2x">&nbsp;&nbsp;</i></a></tr>
            </table>
        </div>
      </footer>
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