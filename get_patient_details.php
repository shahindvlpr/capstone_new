<?php
// Include your database connection file
include('config.php');

$patientIdOrName = $_GET['patient_id_or_name'];

$sql = "SELECT * FROM patients WHERE patient_id = ? OR name LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $patientIdOrName, $patientIdOrName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'name' => $patient['name'],
        'age' => $patient['age'],
        'blood_group' => $patient['blood_group'],
        'gender' => $patient['gender'],
        'email' => $patient['email']
    ]);
} else {
    echo json_encode(['success' => false]);
}

?>
