<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
