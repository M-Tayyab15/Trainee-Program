<?php
$servername = "localhost"; // Corrected hostname
$username = "root"; // Corrected username
$password = ""; // Assuming no password is set for root
$dbname = "db_users"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>