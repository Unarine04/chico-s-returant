<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['user_email'])) {
    // Retrieve username from session
    $username = $_SESSION['user_email'];

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve total amount and pickup time from POST data
        $total_amount = $_POST["total_amount"];
        $pickup_time = $_POST["pickup-time"];

        // Retrieve cart items JSON string from POST data
        $cart_items_json = $_POST["cart"];

        // Database configuration
        $dbHost = 'localhost'; // Change this to your database host
        $dbUsername = 'root'; // Change this to your database username
        $dbPassword = ''; // Change this to your database password
        $dbName = 'chico'; // Change this to your database name

        // Create database connection
        $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL statement to insert order details into 'orders' table
        $stmt = $conn->prepare("INSERT INTO orders (email_address, total_amount, order_date, pickup_time, order_items) VALUES (?, ?, CURDATE(), ?, ?)");
        $stmt->bind_param("sdss", $username, $total_amount, $pickup_time, $cart_items_json);

        if ($stmt->execute() === TRUE) {
            // Order inserted successfully
            echo "Order placed successfully. Order ID: " . $stmt->insert_id;
        } else {
            // Error occurred while inserting order
            echo "Error: " . $stmt->error;
        }

        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // If the request method is not POST, return an error message
        echo "Error: Invalid request method!";
    }
} else {
    // User is not logged in, redirect to login page or return an error message
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>