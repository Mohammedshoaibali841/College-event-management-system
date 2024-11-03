<?php
session_start();
include 'db.php';

// Check if the user is an organizer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $organizer_id = $_SESSION['user_id'];

    // Insert event into database
    $stmt = $conn->prepare("INSERT INTO events (title, description, date, time, location, organizer_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $date, $time, $location, $organizer_id);

    if ($stmt->execute()) {
        echo "Event created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!-- HTML Form to Create Event -->
<h2 style="color: brown; text-align: center; margin-bottom: 20px; padding: 10px;">Create an Event</h2>
<form method="POST" action="" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: rgba(255, 255, 255, 0.8);">
    <input type="text" name="title" placeholder="Event Title" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><br>
    <textarea name="description" placeholder="Event Description" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"></textarea><br>
    <input type="date" name="date" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><br>
    <input type="time" name="time" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><br>
    <input type="text" name="location" placeholder="Location" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><br>
    <input type="submit" value="Create Event" style="width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer; font-size: 1.2em;">
</form>
