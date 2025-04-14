<?php
// Create the table before hand

session_start();

$username = "root";
$passowrd = "";
$host = "localhost";
$db_name = "open_ads";

$conn = new mysqli($host, $username, $passowrd, $db_name);

if ($conn->connect_error) {
    $_SESSION["db_connection"] = "Failed to connect to database";
    die("Connection failed: " . $conn->connect_error);
}else{
    $_SESSION["db_connection"] = "Connected to database";
}

?>