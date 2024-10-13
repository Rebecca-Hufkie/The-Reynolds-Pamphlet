<?php
    define ('SERVERNAME', 'cs3-dev.ict.ru.ac.za');
    define('USERNAME', 'G22G8069');
    define('PASSWORD', 'G22G8069');
    define('DATABASE', 'G22G8069');

    function getDBConnection() {
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }