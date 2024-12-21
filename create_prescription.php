<?php
session_start();

// Check if doctor is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Include the database connection if not already included
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Prescription</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 40%;
            margin-bottom: 5%;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            height: 150px;
            resize: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 12px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .suggestions {
            position: absolute;
            border: 1px solid #ccc;
            background-color: #f4f7f6;
            max-height: 144px;
            overflow-y: auto;
            width: 44%;
            z-index: 1000;
            border-radius: 6px;
            margin-top: -26px;
            color: #000;
            font-weight: 500;
        }

        .suggestions div {
            padding: 8px;
            cursor: pointer;
        }

        .suggestions div:hover {
            background-color: #f0f0f0;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        a.special_a {
            width: 95%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 12px;
            text-align: center;
        }
        a.special_a:hover{
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Create Prescription</h1>
        <form action="submit_prescription.php" method="POST">
            <!-- Input for Patient ID or Name -->
            <label for="patient_id">Patient ID or Name:</label>
            <input type="text" id="patient_id" name="patient_id" placeholder="Enter Patient ID or Name" required><br><br>

            <!-- Patient Details -->
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name" readonly><br><br>

            <label for="patient_age">Age:</label>
            <input type="text" id="patient_age" name="patient_age" readonly><br><br>

            <label for="patient_blood_group">Blood Group:</label>
            <input type="text" id="patient_blood_group" name="patient_blood_group" readonly><br><br>

            <label for="patient_gender">Gender:</label>
            <input type="text" id="patient_gender" name="patient_gender" readonly><br><br>

            <label for="patient_email">Email:</label>
            <input type="email" id="patient_email" name="patient_email" readonly><br><br>

            <!-- Syndrome Field with Suggestions -->
            <label for="syndrome">Syndrome:</label>
            <input type="text" id="syndrome" name="syndrome" autocomplete="off" placeholder="Enter Syndrome" oninput="getSyndromeSuggestions()" required><br><br>

            <div id="syndrome-suggestions" class="suggestions" style="display: none;"></div>

            <!-- Medication Input -->
            <label for="medication">Medication:</label>
            <textarea id="medication" name="medication" required></textarea><br><br>

            <button type="submit">Submit Prescription</button>
        </form>

        <a class="special_a" href="doctor_dashboard.php">Back to Dashboard</a>
    </div>

    <script>
        // Function to fetch patient details based on patient ID or Name
        $('#patient_id').on('input', function() {
            var patientIdOrName = $(this).val();

            if (patientIdOrName.length > 0) {
                $.ajax({
                    url: 'get_patient_details.php', // PHP script to fetch patient details
                    type: 'GET',
                    data: { patient_id_or_name: patientIdOrName },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('#patient_name').val(data.name);
                            $('#patient_age').val(data.age);
                            $('#patient_blood_group').val(data.blood_group);
                            $('#patient_gender').val(data.gender);
                            $('#patient_email').val(data.email);
                        } else {
                            $('#patient_name').val('');
                            $('#patient_age').val('');
                            $('#patient_blood_group').val('');
                            $('#patient_gender').val('');
                            $('#patient_email').val('');
                        }
                    }
                });
            }
        });

        // Function to fetch syndrome suggestions
        function getSyndromeSuggestions() {
            var syndrome = $('#syndrome').val();

            if (syndrome.length > 0) {
                $.ajax({
                    url: 'get_syndrome_suggestions.php', // PHP script to fetch syndrome suggestions
                    type: 'GET',
                    data: { syndrome: syndrome },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var suggestionsDiv = $('#syndrome-suggestions');
                        suggestionsDiv.empty();

                        if (data.suggestions.length > 0) {
                            suggestionsDiv.show();
                            data.suggestions.forEach(function(suggestion) {
                                suggestionsDiv.append('<div onclick="selectSyndrome(\'' + suggestion + '\')">' + suggestion + '</div>');
                            });
                        } else {
                            suggestionsDiv.hide();
                        }
                    }
                });
            } else {
                $('#syndrome-suggestions').hide();
            }
        }

        // Function to select syndrome from suggestions
        function selectSyndrome(syndrome) {
            $('#syndrome').val(syndrome);
            $('#syndrome-suggestions').hide();
        }
    </script>
        <script>
        // Function to fetch syndrome suggestions
        function getSyndromeSuggestions() {
            var syndrome = $('#syndrome').val();

            if (syndrome.length > 0) {
                $.ajax({
                    url: 'get_syndrome_suggestions.php', // PHP script to fetch syndrome suggestions
                    type: 'GET',
                    data: { syndrome: syndrome },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var suggestionsDiv = $('#syndrome-suggestions');
                        suggestionsDiv.empty();

                        if (data.suggestions.length > 0) {
                            suggestionsDiv.show();
                            data.suggestions.forEach(function(suggestion) {
                                suggestionsDiv.append('<div onclick="selectSyndrome(\'' + suggestion + '\')">' + suggestion + '</div>');
                            });
                        } else {
                            suggestionsDiv.hide();
                        }
                    }
                });
            } else {
                $('#syndrome-suggestions').hide();
            }
        }

        // Function to select syndrome from suggestions
        function selectSyndrome(syndrome) {
            $('#syndrome').val(syndrome);
            $('#syndrome-suggestions').hide();
        }
    </script>
</body>
</html>
