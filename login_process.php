<?php
session_start();

include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get login credentials from form
    $login = $_POST['login']; // This will be either username or email
    $password = $_POST['password'];
    $role = $_POST['role']; // User role: doctor or patient

    // Prepare SQL query to check user credentials
    $sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND role = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters to prevent SQL injection
    $stmt->bind_param("sss", $login, $login, $role);

    // Execute the query
    $stmt->execute();

    // Store result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            // Redirect based on user role
            if ($user['role'] == 'doctor') {
                header("Location: doctor_dashboard.php");
            } elseif ($user['role'] == 'patient') {
                header("Location: patient_dashboard.php");
            }
            exit();
        } else {
            // Incorrect password
            header("Location: login.php?error=Invalid username/email or password");
        }
    } else {
        // No user found with the given credentials
        header("Location: login.php?error=Invalid username/email or password");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
