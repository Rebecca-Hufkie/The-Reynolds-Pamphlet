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
  <title>Feedback Page</title>
  <link rel = "stylesheet" href = "CSS/feed.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">

  <script src="JS/feed.js" defer></script>

  <style>
    /* Sliding Side Panel */
    .side-panel {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 999;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 50px;
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

    .side-panel a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 25px;
        color: black;
        display: block;
        transition: 0.3s;
    }

    .top-links a:hover {
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

    .nav-bar li {
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
    .nav-bar ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        overflow: hidden;
    }

    .nav-bar ul li {
        margin-left: 15px;
    }

</style>

</head>
<body>
  <!-- Sliding Side Panel -->
  <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
    <a href="Home.html"><i class="fa-solid fa-home"></i> Home</a>
    <a href="MyConfessions.php"><i class="fa-solid fa-pen-to-square"></i> My Confessions</a>
    <a href="faq.html"><i class="fa-solid fa-question-circle"></i> FAQs</a>
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
<div class="row">
  <!-- Left Column: Contact Card -->
  <div class="column column2">
    <div class="contact-card" style= "background-image: url(Images/Pink1.jpg);">
      <!--<img id="envelope" src="enve.jpeg" alt="envelope" height="200px">-->
      <div class="contact-item" >
        <i class="fas fa-map-marker-alt"></i>
        <span class = "playwrite-cu">Eastern Cape | Makhanda</span>
      </div>
      <div class="contact-item">
        <i class="fas fa-phone-alt"></i>
        <span class = "playwrite-cu">(+27) 123456981</span>
      </div>
      <div class="contact-item">
        <i class="fas fa-envelope"></i>
        <span class = "playwrite-cu"><a href="mailto:theReynoldsPamphlet@gmail.com" style=" color: #944a8a;">theReynoldsPamphlet</a></span>
      </div>

    </div>
  </div>

  <!-- Right Column: Feedback Form -->
  <div class="column column1" style="border: 2px solid black; border-radius: 10px;">
    <h1 style="text-align: center; padding-top:40px;" class="playwrite-cu">Give us your feedback</h1><br>
    <div class="text-column">
      <form id="feedbackForm" name="feedbackForm" class="feedback" action = "Feedback.php" method="post">
        <p class="error" id="nameError"></p>
        <input type="text" id="name" name="name" placeholder="Name" required>

        <p class="error" id="emailError"></p>
        <input type="email" id="email" name="email" placeholder="Example@email.com" required>

        <p class="error" id="feedbackError"></p>
        <textarea id="feedback" name="feedback" rows="4" placeholder="CONFESS how you feel about us&#128521;"></textarea>
        
        <div class="right-bar">
          <button type="button" id="DeleteText"><i class="fa-solid fa-trash"></i></button>
        </div><br>
        

        <input type="submit" value="Submit">

      </form>

      <p id="errorMessage" style="color:red;"></p>
    </div>

    <script src="JS/feed.js"></script>
  </div>
</div>
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
      document.getElementsByTagName("footer")[0].style.marginLeft = "250px";
      document.getElementsByTagName("footer")[0].style.flexDirection = "column";
      document.getElementsByTagName("footer")[0].style.alignItems = "center";
      document.getElementsByTagName("footer")[0].style.textAlign = "center";

      // Define a media query
      const mediaQuery = window.matchMedia('(max-width: 600px)');

      // Function to handle changes in the media query
      function handleMediaChange(e) {
          if (e.matches) {
              document.querySelector('.main-content').style.marginLeft = "0";
          } else {
              document.querySelector('.main-content').style.marginLeft = "250px";
          }
  }

// Initial check
handleMediaChange(mediaQuery);

// Listen for changes in the media query
mediaQuery.addEventListener('change', handleMediaChange);


  }    
  

  function closePanel() {
      document.getElementById("mySidePanel").style.width = "0";
      document.querySelector('.main-content').style.marginLeft = "0";
      document.querySelector('.header-panel').style.marginLeft = "0";
      document.getElementsByTagName("footer")[0].style.marginLeft = "0";
      document.getElementsByTagName("footer")[0].style.display = "flex";
      document.getElementsByTagName("footer")[0].style.alignItems = "center";
      document.getElementsByTagName("footer")[0].style.justifyContent = "space-around";


      // Define a media query
      const mediaQuery = window.matchMedia('(min-width: 600px)');
      const medQuery = window.matchMedia('(max-width: 600px)');

      // Function to handle changes in the media query
      function handleMediaChange(e) {
          if (e.matches) {
              document.querySelector('.main-content').style.marginLeft = "250px";
          } else {
              document.querySelector('.main-content').style.marginLeft = "0";
          }
      }

      // Function to handle changes in the media query
      function handleCloseMediaChange(e) {
          if (e.matches) {
              document.querySelector('.main-content').style.marginLeft = "0";
          } else {
              document.querySelector('.main-content').style.marginLeft = "0";
          }
      }

      // Initial check
      handleMediaChange(mediaQuery);
      handleCloseMediaChange(medQuery);

      // Listen for changes in the media query
      mediaQuery.addEventListener('change', handleMediaChange);
      medQuery.addEventListener('change', handleCloseMediaChange);
  }
</script>

</body>
</html>
