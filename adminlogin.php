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
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL statement to retrieve admin data
$sql = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Admin found, verify password
    $row = mysqli_fetch_assoc($result);
    if ($password === $row['password']) {
        // Password correct, redirect to the admin page
        $_SESSION['admin_email'] = $email;
        header("Location: adminpage.html");
        exit();
    } else {
        // Incorrect password
        echo "Incorrect password";
    }
} else {
    // Admin not found
    echo "Admin not found";
}

mysqli_close($conn);
?>