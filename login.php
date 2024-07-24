<?php
session_start();

// Database configuration
$dbHost = 'localhost'; // Change this to your database host
$dbUsername = 'root'; // Change this to your database username
$dbPassword = ''; // Change this to your database password
$dbName = 'chico'; // Change this to your database name

// Create database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



// Fetch form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to retrieve user data
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // User found, verify password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
        // Password correct, redirect to the home page
		$_SESSION['user_email'] = $username; // Changed to 'username' as 'user_email' was not defined
        header("Location: Products.html");
        exit();
    } else {
        // Incorrect password
        echo "Incorrect password";
    }
} else {
    // User not found
    echo "User not found";
}

mysqli_close($conn);
?>