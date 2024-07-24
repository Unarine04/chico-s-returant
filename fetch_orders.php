<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chico";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

$ordersData = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $ordersData[] = $row;
    }
}

// Close connection
$conn->close();

// Return orders data as JSON
header('Content-Type: application/json');
echo json_encode($ordersData);
?>