<?php

$host = "localhost";
$usernameDB = "root";
$passwordDB = "";
$database = "cookiebase";

// Create connection
$conn = mysqli_connect($host, $usernameDB, $passwordDB, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>