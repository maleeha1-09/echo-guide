<?php
session_start();
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "obstacle_db";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>