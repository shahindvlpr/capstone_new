<?php
session_start();

// Check if either username or email is set in session and the role is 'doctor'
if ((!isset($_SESSION['username']) && !isset($_SESSION['email'])) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .container {
    width: 90%;
    margin: 0 auto;
}
.container {
    width: 90%;
    margin: 0 auto;
}

.container h1.dr-name-design {
    /* float: right; */
    display: block;
    padding-top: 20px;
    padding-bottom: 20px;
}

.btn-design {}

.btn-design {
    float: left;
    text-align: center;
    width: 100%;
    margin: 0 auto;
    margin-top: 100px;
}

.btn-design a {
    text-decoration: none;
    color: #000;
    font-size: 25px;
    background: #1692bb;
    padding: 20px 40px 20px 40px;
    border-radius: 5px;
    font-weight: 800;
}

.btn-design a:hover {
    color: #fff;
    background: #000;
    transition: 1s all;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="dr-name-design">Welcome, Dr. 
            <?php
            // Display the username if available, otherwise display the email
            if (isset($_SESSION['username'])) {
                echo $_SESSION['username'];
            } elseif (isset($_SESSION['email'])) {
                echo $_SESSION['email'];
            }
            ?>!
        </h1>
        <div class="btn-design">
            <a href="create_prescription.php">Create Prescription</a> <br>
        </div>
        <div class="btn-design">
            <a href="login.php">Logout</a>
        </div>
    </div>
</body>
</html>
