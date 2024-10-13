<?php 
    // ensure user logs in first
    require_once("secure.php");

    // get database connection details and create connection
    require_once("../toolkit/config.php"); 
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Management Table</title>
        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="../CSS/styles.css">
        <link rel="stylesheet" href="../CSS/user.css">
        <link rel="stylesheet" href="../CSS/admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playwrite+CU:wght@100..400&display=swap" rel="stylesheet">
    </head>
    <body>
            <!-- Sliding Side Panel -->
        <div id="mySidePanel" class="side-panel">
            <div class = "top-links">
                <a href="MyConfessions.php"><i class="fa-solid fa-home"></i> Admin Dashboard</a>
                <a href="../dashboard/index.php"><i class="fa-solid fa-pen-to-square"></i>Reports</a>
                
                <a href="admin.php"><!-- <img src="images/ban-unban-icon.jpg" class="sidebar-icon" alt="Ban/Unban Icon"> --><i class="fa-solid fa-gears"></i>User Manangement</a>
                
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
        
        <section id="table">
            <table>
                <thead>
                    <tr>
                        <th style="background-color: #EA638C;">Full Name</th>
                        <th style="background-color: #EA638C;">Alias</th>
                        <th style="background-color: #EA638C;">User Role</th>
                        <th style="background-color: #EA638C;">Status</th>
                        <th style="background-color: #EA638C;">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        // create and bind the query which returns all users
                        $get_users_stmt = $conn->prepare("SELECT * FROM users");// WHERE role != ?;");
                        //$get_users_stmt->bind_param("s", $_SESSION['role']);

                        // execute and get results of query
                        $get_users_stmt->execute();
                        $get_users_stmt_result = $get_users_stmt->get_result();

                        // check if admin was found
                        if ($get_users_stmt_result->num_rows > 0) {
                            // display all users in a table
                            while ($admin = $get_users_stmt_result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$admin['firstName']} {$admin['lastName']}</td>
                                <td>{$admin['alias']}</td>
                                <td>{$admin['role']}</td>";
                                switch ($admin['accountStatus']) {
                                    case "Active":
                                        echo "<td><span id='active'><span class='circle'></span>&nbsp;&nbsp;<span class='text'>{$admin['accountStatus']}</span></span></td>";
                                        break;
                                    case "Banned":
                                        echo "<td><span id='banned'><span class='circle'></span>&nbsp;&nbsp;<span class='text'>{$admin['accountStatus']}</span></span></td>";
                                        break;
                                    default:
                                        echo "<td><span id='banned'><span class='circle'></span>&nbsp;&nbsp;<span class='text'>{$admin['accountStatus']}</span></span></td>";
                                }
                                
                                echo "<td>
                                    <form action='ban_unban_user.php' method='post'>
                                        <input type='hidden' name='user_id' value='{$admin['UserID']}'>
                                        <input type='hidden' name='f_name' value='{$admin['firstName']}'>
                                        <button type='submit' name='ban_user' class='ban-user-btn'><span class='text'>Ban User</span></button>
                                        <button type='submit' name='unban_user' class='unban-user-btn'><span class='text'>Unban User</span></button>
                                        <a href='../reactivate.php'><button class='ban-user-btn'  >Reactivate</button></a>
                                    </form>
                                </td>
                            </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <script src="script.js"></script>
        <script src="admin.js"></script>
    </body>
</html>