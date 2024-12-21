<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 330px;
            text-align: center;
        }

        .login-container img {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .register-link {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .role-message {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .success-popup {
            position: fixed;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
            font-size: 16px;
        }

        .success-popup button {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
    <script>
        function updateRoleMessage() {
            const roleSelect = document.querySelector('select[name="role"]');
            const roleMessage = document.getElementById('role-message');
        }

        function closePopup() {
            const popup = document.getElementById('success-popup');
            if (popup) {
                popup.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="login-container">
        <img src="login.jpg" alt="Login Icon">
        <form action="login_process.php" method="POST">
            <!-- Now the user can input either username or email -->
            <input type="text" name="login" placeholder="Username or Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="doctor">Doctor</option>
                <option value="patient">Patient</option>
            </select>
            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        <a href="register.php" class="register-link">Not registered? Create an account here</a>
        <?php
            if (isset($_GET['success']) && !empty($_GET['success'])) {
                echo "<div id='success-popup' class='success-popup'>" . 
                    htmlspecialchars($_GET['success']) . 
                    "<button onclick='closePopup()'>×</button></div>";
            }
        ?>
        <?php
            if (isset($_GET['error']) && !empty($_GET['error'])) {
                echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
        ?>
    </div>
</body>
</html>
