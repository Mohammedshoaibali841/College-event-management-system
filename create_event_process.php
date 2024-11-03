<?php
session_start(); // Start the session
include 'db.php'; // Include your database connection

// Check if user is logged in and is an organizer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php"); // Redirect to login if not authorized
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $organizer_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO events (title, description, date, time, location, organizer_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $date, $time, $location, $organizer_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Event created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
