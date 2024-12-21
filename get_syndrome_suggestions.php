<?php
// Include your database connection
include('config.php');

// Check if 'syndrome' parameter is provided
if (isset($_GET['syndrome'])) {
    $syndrome = $_GET['syndrome'];

    // Prepare the query to fetch matching syndrome names from your database
    $sql = "SELECT syndrome_name FROM syndromes WHERE syndrome_name LIKE ? LIMIT 5";
    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = "%{$syndrome}%";
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch suggestions and return them as a JSON response
        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = $row['syndrome_name'];
        }

        // Return the suggestions as JSON
        echo json_encode(['suggestions' => $suggestions]);
    } else {
        echo json_encode(['suggestions' => []]); // Return empty suggestions if no matching records
    }
}
?>
