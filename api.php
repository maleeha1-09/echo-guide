<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: text/plain");

// Debug output
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obstacle_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("CONN_FAIL:" . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $distance = isset($_POST['distance']) ? (float)$_POST['distance'] : 0;
    
    error_log("Received distance: " . $distance); // Debug log
    
    $stmt = $conn->prepare("INSERT INTO sensor_data (distance) VALUES (?)");
    $stmt->bind_param("d", $distance);
    
    if($stmt->execute()) {
        echo "DATA_ACCEPTED";
    } else {
        echo "DB_ERROR:" . $stmt->error;
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo "INVALID_METHOD";
}

$distance = isset($_POST['distance']) ? (float)$_POST['distance'] : 0;

if($distance < 2 || $distance > 400) {
    die("INVALID_READING");
}

$conn->close();
?>