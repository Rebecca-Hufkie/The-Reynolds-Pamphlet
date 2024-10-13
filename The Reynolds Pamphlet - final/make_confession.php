<?php
    // start session for user authentication and security
    require_once('secure.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="CSS/make_confession.css">
        <link rel="stylesheet" href="CSS/styles.css">
        <title>Make a Confession</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    
    </head>
    <body style="background-color: aliceblue;">
        <!-- Sliding Side Panel -->
    <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
        <a href="confessions.php"><i class="fa-solid fa-home"></i> Home</a>
        <a href="MyConfessions.php"><i class="fa-solid fa-book"></i> My Confessions</a>
        <a href="faq.html"><i class="fa-solid fa-question-circle"></i> FAQs</a>
        <a href="Feed.php"><i class="fa-solid fa-comments"></i> Feedback</a>
        <a href="user.php"><i class="fa-solid fa-user"></i>  Profile</a>
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

    <div id = "logout-popup" class = "popup">
            <div class = "popup-content">
              <a href = "#" class = "close-btn">&times;</a>
              <h2>Leaving so soon?</h2>
              <button id="confirmButton">Yes</button>
              <button id = "cancelButton" >Cancel</button>
            </div>
          </div>
          <script src ="JS/profile.js"></script>  

         
        <div class="main-content">
        <div class="container">
            <div class="form-container" id="form-container">
            <form id="confession-form" action="<?php echo htmlspecialchars("submit_confession.php"); ?>" method="post">
                <h3><label for="confession">Type Your Confession below:</label></h3>
                <textarea id="confession" name="confession" rows="7" required autofocus style="max-width: 28.0625rem; height: 9.4375rem;"></textarea><br>
                
                <select class="Confession-dropdown" name="category">
                    <option value="" selected disabled>Choose a confession Category:</option>
                    <option style="color: #ea638c" value="Love">Love</option>
                    <option style="color:#6f6194;" value="Tea/Drama">Tea/Drama</option>
                    <option style="color: #ecd6ff ;" value="Campus Scandals">Campus Scandals</option>
                    <option style="color: #b8d9e0;" value="Mental Health">Mental Health</option>
                </select>

                <!-- Ensure the button has the name attribute matching what PHP expects -->
                <button type="submit" id="submit-confession-btn" name="confession_submit"><strong>Submit Confession</strong></button>
            </form>

            </div>
            <!-- Envelope animation elements -->
            <div class="envelope hidden" id="envelope">
                <div class="flap"></div>
                <div class="seal"></div>
            </div>
            <!-- Thank you message displayed after submission -->
            <?php
                // Determine if the thank-you message should be shown
                $showThankYou = isset($_GET['submitted_successfully']) && $_GET['submitted_successfully'] === 'true';
                $thankYouClass = $showThankYou ? 'thank-you' : 'thank-you hidden';
                echo "<div class='$thankYouClass' id='thank-you-message'>
                        <p>Thanks for submitting a confession! 😆</p>
                        <div class='button-container'>
                            <a href='confessions.php'><button type='button' id='back-home'>Back Home</button></a>
                            <a href='Myconfessions.php'><button type='button' id='view-confessions'>View Your Confessions</button></a>
                            <a href='make_confession.php'><button type='button' id='make-another'>Make Another Confession</button></a>
                        </div>
                    </div>";
            ?>
        </div>
        <script src='JS/make_confession.js'></script>

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
