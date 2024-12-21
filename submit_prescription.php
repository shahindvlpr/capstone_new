<?php
session_start();
include('config.php');

// Check if doctor is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $medication = $_POST['medication'];

    // Insert prescription into the database (assuming there's a 'prescriptions' table)
    $sql = "INSERT INTO prescriptions (doctor_id, patient_id, medication) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $doctor_id = $_SESSION['id']; // Get the doctor's ID from the session
        $stmt->bind_param("iis", $doctor_id, $patient_id, $medication);
        $stmt->execute();

        // Redirect or show success message
        header("Location: doctor_dashboard.php?success=Prescription created successfully.");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
