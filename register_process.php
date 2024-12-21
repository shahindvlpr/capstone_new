<?php
include('config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $blood_group = $_POST['blood_group'];
    $role = $_POST['role'];
    $username = $_POST['username']; 
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check if the username already exists in the database
    $sql_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Username already exists
        echo "Error: The username is already taken. Please choose another one.";
    } else {
        // Insert user into the database
        $sql = "INSERT INTO users (first_name, last_name, dob, phone, email, address, gender, marital_status, blood_group, role, username, password)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind the insert statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $first_name, $last_name, $dob, $phone, $email, $address, $gender, $marital_status, $blood_group, $role, $username, $password);

        if ($stmt->execute()) {
            // Redirect to login page with a success message
            header("Location: login.php?success=Account successfully created. Please login.");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the prepared statements
    $stmt_check->close();
    $stmt->close();
}

$conn->close();
?>
