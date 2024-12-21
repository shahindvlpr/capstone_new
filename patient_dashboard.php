<?php
session_start();

// Check if either username or email is set in session and the role is 'patient'
if (!isset($_SESSION['username']) && !isset($_SESSION['email']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
</head>
<body>
    <h1>Welcome, 
        <?php
        // Display the username if available, otherwise display the email
        if (isset($_SESSION['username'])) {
            echo $_SESSION['username'];
        } elseif (isset($_SESSION['email'])) {
            echo $_SESSION['email'];
        }
        ?>!
    </h1>
    <a href="login.php">Logout</a>
</body>
</html>
