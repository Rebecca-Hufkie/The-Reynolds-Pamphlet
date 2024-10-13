<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        /* padding-top: 50px; */
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

        .custom-button {
    background-color: #EA638C; /* Button background */
    color: #360a30; /* Button text color */
    padding: 10px 20px; /* Padding inside the button */
    border: none; /* Removes border */
    border-radius: 5em; /* Rounds the corners */
    cursor: pointer; /* Changes cursor to pointer on hover */
    font-size: 16px; /* Button font size */
    font-weight: bold; /* Makes the button text bold */
    transition: background-color 0.3s ease; /* Smooth color change on hover */
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
<body>

    <!-- Sliding Side Panel -->
    <div id="mySidePanel" class="side-panel">
    <div class = "top-links">
            <a href="../Admin/MyConfessions.php"><i class="fa-solid fa-home"></i> Admin Dashboard</a>
            <a href="../Admin/RejectedConfessions.php"><i class="fa-solid fa-xmark"></i>Rejected Confessions</a>
            <a href="index.php"><i class="fa-solid fa-pen-to-square"></i>Reports</a>
            <a href="../Admin/admin.php"><!-- <img src="images/ban-unban-icon.jpg" class="sidebar-icon" alt="Ban/Unban Icon"> --><i class="fa-solid fa-gears"></i>User Manangement</a>
           
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
        require_once("config.php");
        //make a connection
        $conne = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
                                
                                                    
        if ($conne -> connect_error) {
            die("<p>Connection failed: Incorrect credentials</p>");
        }

    ?>

   <div class="main-content">
    <div class="the_stats">
        <h1>Statistics</h1>
        <!-- Total Confessions Chart -->
        <div class="container">
            
            <div class="chart-container">
                <h2>Total Confessions per Catergory</h2>
                <canvas id="totalSalesChart"></canvas>
            </div>

            <div>
             <!-- Top Metrics -->
                <div class="metrics-container">
                    <?php 
                        $Account_type = array('Active', 'Banned', 'Deactivated', 'Total');
                        $total = 0;
                        $index = 0;

                        foreach ($Account_type as $value){
                            echo "<div class='metric'>";
                            echo "<h3>{$value}</h3>";

                            if($index < 3){

                                $sql = "SELECT * FROM users where accountStatus = '$value' ";
                            
                                $confessions_results = $conne -> query($sql);
                        
                                if ($confessions_results === FALSE) {
                                    die("<p>Query Unsuccessful!</p>");
                                }

                                echo "<p>{$confessions_results -> num_rows}</p>";
                                $total += ($confessions_results -> num_rows);
                                $index++;
                                echo "</div>";
                            }

                            else{
                                echo "<p>$total</p>";
                                echo "</div>";
                            }

                        }
                        

                    ?>
                </div>
                <div class="box-2">
                    <div class="container">
                        <!-- Confessions Funnel -->
                        <div class="funnel-container">
                            <h2>Confessions Funnel</h2>

                            <?php 
                                $confession_type = array('Accepted', 'Submitted', 'Rejected', 'Total');
                                $total = 0;
                                $index = 0;

                                foreach($confession_type as $value){
                                    echo "<div class='funnel-metric'>";
                                    echo "<p>{$value} Confessions </p>";

                                    if($index < 3){

                                        $sql = "SELECT * FROM confessions where status = '$value' ";
                                    
                                        $confessions_results = $conne -> query($sql);
                                
                                        if ($confessions_results === FALSE) {
                                            die("<p>Query Unsuccessful!</p>");
                                        }
        
                                        echo "<p>{$confessions_results -> num_rows}</p>";
                                        $total += ($confessions_results -> num_rows);
                                        $index++;
                                        echo "</div>";
                                    }
                                    else{
                                        echo "<p>$total</p>";
                                        echo "</div>";
                                    }
                                }
                            ?>
                        </div>

                        <!-- Confessions by Category -->
                        <div class="category-confess-container">
                            <h2>Confessions by Category</h2>
                            <canvas id="categorySalesChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>


        </div>



    </div>
   </div>

    <script src="scripts.js"></script>

    <script>
        // Total Sales Chart
        const totalSalesCtx = document.getElementById('totalSalesChart').getContext('2d');
        const totalSalesChart = new Chart(totalSalesCtx, {
            type: 'bar',
            data: {
                labels: ['Love', 'Tea/Drama', 'Campus Scandals', 'Mental Health'],
                datasets: [{
                    label: 'Confessions',
                    data: [
                        <?php 
                            $categories = array('Love', 'Tea/Drama', 'Campus Scandals', 'Mental Health');
                            foreach($categories as $value){
                        
                                $sql = "SELECT * FROM confessions where category = '$value' ";
                        
                                $confessions_results = $conne -> query($sql);
                        
                                if ($confessions_results === FALSE) {
                                    die("<p>Query Unsuccessful!</p>");
                                }
                        
                                echo $confessions_results -> num_rows.",";

                            }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(234, 99, 140, 0.5)',  // blue
                        'rgba(111, 97, 148, 0.5)',  // red/pink
                        'rgba(236, 214, 255, 0.5)',  // teal
                        'rgba(184 ,217, 224, 0.5)'  // purple (new)
                    ],
                    borderColor: [
                        'rgba(234, 99, 140,1)',    // blue
                        'rgba(111, 97, 148, 1)',    // red/pink
                        'rgba(236, 214, 255, 1)',    // teal
                        'rgba(184, 217, 224, 1)'    // purple (new)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                }
            }
        });
        
        const categorySalesCtx = document.getElementById('categorySalesChart').getContext('2d');
        const categorySalesChart = new Chart(categorySalesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Love', 'Tea/Drama', 'Campus Scandals', 'Mental Health'],
                datasets: [{
                    label: 'Sales by Category',
                    data: [
                        <?php 
                            $categories = array('Love', 'Tea/Drama', 'Campus Scandals', 'Mental Health');
                            foreach($categories as $value){
                        
                                $sql = "SELECT * FROM confessions where category = '$value' ";
                        
                                $confessions_results = $conne -> query($sql);
                        
                                if ($confessions_results === FALSE) {
                                    die("<p>Query Unsuccessful!</p>");
                                }
                        
                                echo $confessions_results -> num_rows.",";

                            }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(234, 99, 140,0.5)',  // blue
                        'rgba(111, 97, 148, 0.5)',  // red/pink
                        'rgba(236, 214, 255, 0.5)',  // teal
                        'rgba(184 ,217, 224, 0.5)'  // purple (new)
                    ],
                    borderColor: [
                        'rgba(234, 99, 140,1)',    // blue
                        'rgba(111, 97, 148, 1)',    // red/pink
                        'rgba(236, 214, 255, 1)',    // teal
                        'rgba(184, 217, 224, 1)'    // purple (new)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

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
