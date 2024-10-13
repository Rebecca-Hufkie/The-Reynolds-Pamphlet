<?php
require_once("secure.php");

// Check if the role is set and the user is not a 'Confessor'
if(isset($_SESSION['role']) && $_SESSION['role'] != 'Confesser') {
    header("Location: Home.html");
    exit(); // Make sure to exit after redirection
}

// Database connection
require_once("toolkit/config.php");
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session variable is set
if (!isset($_SESSION['userId'])) {
    die("User ID not set in session.");
}

// Escape the user ID (although prepared statements already handle this safely)
$userId = $_SESSION['userId'];

// Prepare the SQL statement to query by UserID
$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the user ID (assuming userId is an integer)
$stmt->bind_param("i", $userId);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if a matching user was found
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();

    // Set session variables (escape output for security)
    $_SESSION['userName'] = htmlspecialchars($row['username']);
    $_SESSION['email'] = htmlspecialchars($row['email']);
    $_SESSION['firstName'] = htmlspecialchars($row['firstName']);
    $_SESSION['lastName'] = htmlspecialchars($row['lastName']);
    $_SESSION['alias'] = htmlspecialchars($row['alias']);
} else {
    echo "No matching user found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,height=device-height, minimum-scale=1.0, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel = "stylesheet" href = "CSS/user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">

  <script src="JS/profile.js" defer></script>

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

    .side-panel a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 25px;
        color: black;
        display: block;
        transition: 0.3s;
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
        right: 15px;
        overflow: hidden;
    }

    .nav-bar ul li {
        margin-left: 15px;
    }

</style>
</head>
<body style="background-color: aliceblue;">

  <!-- Sliding Side Panel -->
  <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
        <a href="confessions.php"><i class="fa-solid fa-home"></i> Home</a>
        <a href="MyConfessions.php"><i class="fa-solid fa-book"></i> My Confessions</a>
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

<div class = "main-content">
<div class = "body-container">
<div class="row">
  <!-- Left Column: Contact Card -->
  <div class="column column2">
  
  <?php
  // Include your database connection
  require_once 'toolkit/config.php';

  // Assuming userId is stored in session
  $userId = $_SESSION['userId'];  // Update this if your session variable is different

  $mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

  // Check for connection errors
  if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
  }

  // Query to get the profile picture
  $stmt = $mysqli->prepare("SELECT profilePic FROM users WHERE UserID = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $stmt->bind_result($profilePic);
  $stmt->fetch();
  $stmt->close();

  // Set default image if profilePic is null or empty
  if (empty($profilePic)) {
      $profilePic = "Images/facepic.png";  // Path to your default image
  }

  $mysqli->close();
  ?>

  <!-- HTML to display the profile image -->
  <img id="myImg" src="<?php echo $profilePic; ?>" alt="Profile Picture" style="width:100%;max-width:300px;cursor:pointer; ">
  
  <!-- Modal Structure -->
  <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
  </div>

  <!-- Profile picture upload form -->
  <form id="profileForm" action="<?php echo htmlspecialchars("changeProfile.php"); ?>" method="POST" enctype="multipart/form-data">
      <label for="profilePicUpload" class="custom-button" style="width: 250px; display: inline-block; padding: 10px; text-align: center; background-color: #cc3366; color: white; cursor: pointer;">
          Change Profile
      </label>
      <input type="file" id="profilePicUpload" name="profilePic" style="display: none;" accept="image/*" onchange="submitForm()">
  </form>

  <script>
  function submitForm() {
      document.getElementById("profileForm").submit();
  }

  // Modal behavior
  var modal = document.getElementById("myModal");
  var img = document.getElementById("myImg");
  var modalImg = document.getElementById("img01");

  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
  }

  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() { 
    modal.style.display = "none";
  }
  </script>

  <!-- End of column column2 -->

            
            <div class = "card-container">
              <h3 style = "font-size: 2em;" class="playwrite-cu"><b><?php echo $_SESSION['userName'];?></h3>
            </div>  
            </div>
  

  <!-- Right Column: Feedback Form -->
  <div class="column column1">
    <div id = "details" class = "contact-card">
      <div class = "card-container" id="card-container">
        <h3 id = "details" class="playwrite-cu">Details</h3>
        <h6 style="text-align: left; padding-left:20px;">Firstname</h6>
        <p class = "detailsPara"><span id = "Firstname-display"><?php echo $_SESSION['firstName'] ;?></span></p>

        <h6 style="text-align: left; padding-left:20px;">Lastname</h6>
        <p class = "detailsPara"><span id = "username-display"><?php echo $_SESSION['lastName'] ;?></span></p>

        <h6 style="text-align: left; padding-left:20px;">Email</h6>
        <p class = "detailsPara"><span id = "email-display"><?php echo $_SESSION['email'] ;?></span></p>

        <h6 style="text-align: left; padding-left:20px;">Alias</h6>
        <p class = "detailsPara"><span id = "username-display"><?php echo $_SESSION['alias'];?></span></p>
      </div> 

      <!-- form to edit details - hidden by default -->
      <form id="edit_profile_form" action="editProfile.php" method="post">
        <h3 id = "details" class="playwrite-cu">Details</h3>
        <!--FirstName-->
        <h6 style="text-align: left; padding-left:20px;">First Name</h6>
        <p class="error" id="nameError"></p>
        <input class = "detailsPara" style="border: 0rem; width: 95%;" type="text" name="First-name" id="first-name" value="<?php print_r($_SESSION['firstName']);?>"><br>      
        
        <!--LastName-->  
        <h6 style="text-align: left; padding-left:20px;">Last Name</h6>
        <p class="error" id="nameError"></p>
        <input class = "detailsPara" style="border: 0rem; width: 95%;" type="text" name="Last-name" id="last-name" value="<?php echo $_SESSION['lastName'] ;?>"><br>   
        
        <!--Email-->
        <h6 style="text-align: left; padding-left:20px;">Email</h6>
        <p class="error" id="emailError"></p>
        <input class = "detailsPara" style="border: 0rem; width: 95%;" type="email" name="user-email" id="user-email" value="<?php echo $_SESSION['email'] ;?>"><br>

        <!--Alias-->
        <h6 style="text-align: left; padding-left:20px;">Alias</h6>
        <p class="error" id="nameError"></p>
        <input class = "detailsPara" style="border: 0rem; width: 95%;" type="text" name="user-name" id="user-name" value="<?php echo $_SESSION['alias'] ;?>"><br>     

        <button type="submit" id = "save-Button" class = "custom-button" style="display:none;">Save Changes</button> <br>
        
      </form>

      <div>
        
        <p><button class="custom-button" id="edit-profile">Edit Profile</button></p>
        <p><a href = "MyConfessions.php"><button class="custom-button" id="confessions">My Confessions</button></a></p>
        <p>
          <button class="custom-button" id="delete-account" 
                 onclick="if(confirm('Are you sure you want to deactivate your account?'))  { window.location.href = 'deactivate.php'; }">
              Deactivate Account
          </button>
      </p>
       
      </div>

      <!-- Delete Popup 
      <div id = "delete-popup" class = "popup">
        <div class = "popup-content">
          <a href = "#" class = "close-btn">&times;</a>
          <h2>Are you sure you want to deactivate your?</h2>
          <button id="confirmButton">Yes</button>
          <button id = "cancelButton" >Cancel</button>
        </div>
      </div>-->
      <script src ="JS/profile.js"></script>  
    </div>
  </div>
  
</div>
<script src="JS/profile.js"></script>
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
            document.getElementsByTagName("footer")[0].style.marginLeft = "250px";
            document.getElementsByTagName("footer")[0].style.flexDirection = "column";
            document.getElementsByTagName("footer")[0].style.alignItems = "center";
            document.getElementsByTagName("footer")[0].style.textAlign = "center";

            // fix this bucko
            // document.querySelector('.column column 1').style.;

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