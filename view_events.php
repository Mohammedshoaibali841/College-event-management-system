<?php
session_start();
include 'db.php';

// Ensure the user is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Query to get ongoing and upcoming events
$current_date = date("Y-m-d");
$stmt = $conn->prepare("SELECT title, description, date, time, location FROM events WHERE date >= ? ORDER BY date, time");
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ongoing and Upcoming Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('./stars.jpg'); /* Update path as necessary */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent repeat */
            color: white; /* Text color for visibility */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Full viewport height */
        }

        h2 {
            color: brown; 
            text-align: center; 
            font-weight: bold;
            margin-top: 20px; /* Margin for spacing */
        }

        table {
            border-collapse: collapse; 
            width: 80%; /* Table width */
            margin: 20px 0; /* Margin for spacing */
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for table */
            color: #333; /* Text color for table */
        }

        th, td {
            padding: 10px; 
            text-align: left; 
            border: 1px solid #ddd; /* Border style for table */
        }

        th {
            background-color: #f2f2f2; /* Header background color */
        }

        p {
            text-align: center; /* Centered paragraph */
            color: #fff; /* Text color for no events message */
        }
    </style>
</head>
<body>

<h2 style="color: white;">Ongoing and Upcoming Events</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
    <tr>
        <th>Event Name</th>
        <th>Description</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
    </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No ongoing or upcoming events found.</p>
<?php endif; ?>

<?php $stmt->close(); ?>
</body>
</html>

