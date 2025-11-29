<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "cookiebase";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>