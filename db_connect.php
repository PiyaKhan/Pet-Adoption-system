<?php
$host = 'localhost'; // Database host
$db_username = 'root'; // Your database username
$db_password = ''; // Your database password
$db_name = 'pet_adoption'; // Your database name

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally set charset
$conn->set_charset("utf8");
?>
