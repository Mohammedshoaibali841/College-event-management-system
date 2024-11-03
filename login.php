<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to check for user
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashed_password, $user_role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = $user_role;
            $_SESSION['username'] = $username;

            // Redirect based on role
            if ($user_role === 'organizer') {
                header("Location: create_event.php");
                exit();
            } elseif ($user_role === 'student') {
                header("Location: view_events.php");
                exit();
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
    $stmt->close();
}
?>

<!-- HTML Form for Login -->
<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>
