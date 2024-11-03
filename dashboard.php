<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve the username from the session
$username = $_SESSION['username']; // Fetch the username from the session

// Display the welcome message
echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";
?>
