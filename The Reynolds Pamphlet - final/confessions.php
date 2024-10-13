<?php
    require_once("secure.php");
    if(isset($_SESSION['role']) && $_SESSION['role'] != 'Confesser' && $_SESSION['accountStatus'] !== 'Active'){
    header("Location: Home.html");
    }
?>


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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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

    a {
        text-decoration-line: none;
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

    .delete-icon{
        background-color: white;
    }


</style>
</head>
<body style="background-color: aliceblue;">

    <!-- Sliding Side Panel -->
    <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
        <a href="#"><i class="fa-solid fa-home"></i> Home</a>
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

    
    <!-- Main Content -->
    <div class="main-content">
        <main>
            <!-- Rest of your content goes here -->
            <section class="home" id="home">
                <div class="search-bar-container">
                <form method="GET" action="">
                    <input type="text" class="search-input" name = "search" placeholder="Search confessions...">
                    <button  class = "search-button" type = "submit"><i class="fas fa-search"></i></button>
                </form>
                </div>

                <form>
                    <div class="radio-group">
                        <label class="radio-container">
                            <input type="radio" name="options" value="all" checked>
                            <span class="checkmark"></span>
                            All Confessions
                        </label>
                        <label class="radio-container">
                            <input type="radio" name="options" value="Love">
                            <span class="checkmark"></span>
                            Love
                        </label>
                        <label class="radio-container">
                            <input type="radio" name="options" value="Tea/Drama" >
                            <span class="checkmark"></span>
                            Tea/Drama
                        </label>
                        <label class="radio-container">
                            <input type="radio" name="options" value="Campus Scandals">
                            <span class="checkmark"></span>
                            Campus Scandals
                        </label>
                        <label class="radio-container">
                            <input type="radio" name="options" value="Mental Health">
                            <span class="checkmark"></span>
                            Mental Health
                        </label>
                    </div>
                </form>

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

            
                    if ($conne -> connect_error) {
                        die("<p>Connection failed: Incorrect credentials</p>");
                    } 

                    // Include the search query logic here
                    $searchTerm = '';
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchTerm = $conne->real_escape_string($_GET['search']); // Sanitize input to prevent SQL injection
                    }

                    // Define the SQL query
                    if (!empty($searchTerm)) {
                        // Search for confessions based on the search term (in description and alias fields)
                        $sql = "SELECT * FROM confessions WHERE (description LIKE '%$searchTerm%' OR alias LIKE '%$searchTerm%') AND status = 'Accepted' ORDER BY confessionID DESC";
                    } else {
                        // Default query to show all accepted confessions if there's no search term
                        $sql = "SELECT * FROM confessions WHERE status = 'Accepted' ORDER BY confessionID DESC";
                    }

                    // Execute the query
                    $confessions_results = $conne->query($sql);

                    if ($confessions_results === FALSE) {
                        die("<p>Query Unsuccessful!</p>");
                    }

                    // Display the confessions
                    while($confession =  $confessions_results->fetch_assoc()) {

                        $cardColor = '';
                        $category = $confession['category'];

                        switch($category) {
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

                        echo "<div class='card-item' data-category = '{$category}' {$cardColor} >";

                        if($_SESSION['role'] == "Admin"){
                            echo "<a href = 'del_confession.php?confessionid={$confessionid}' > <p> <i class='material-icons'>delete</i> </p> </a>";
                        }
                        echo "<a href='CommentSection/commentSec.php?confessionid={$confession['confessionID']}'>";
                        echo "<span class= 'developer'>{$confession['alias']}</span>";
                        echo "<h3>{$confession['description']}</h3>";
                        echo "</a>";
                        echo "</div>";
                    }
                    ?>
    
                
                </div>
            </section>  
        </main>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const radioButtons = document.querySelectorAll('input[name="options"]');
        const confessionCards = document.querySelectorAll('.card-item');

        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedValue = this.value;

                confessionCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');

                    // Debugging log to see selected value and card category
                    console.log(`Selected: ${selectedValue}, Card Category: ${cardCategory}`);
                    
                    // Show all if 'all' is selected, or filter by category
                    if (selectedValue === 'all' || card.getAttribute('data-category') === selectedValue) {
                        card.style.display = 'block'; // Show confession
                    } else {
                        card.style.display = 'none'; // Hide confession
                    }
                });
            });
        });

        // Trigger change event on page load to show default selections
        radioButtons.forEach(radio => {
            if (radio.checked) {
                radio.dispatchEvent(new Event('change'));
            }
        });
    });
    </script>


</body>
</html>
