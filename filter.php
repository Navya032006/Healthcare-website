<?php
require_once 'db.php';

$response = [
    'status' => 'success',
    'message' => '',
    'hospitals' => []
];

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

$location = isset($_POST['location']) ? $_POST['location'] : '';
$specialty = isset($_POST['specialty']) ? $_POST['specialty'] : '';
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

$query = "SELECT DISTINCT h.* FROM hospitals h ";

if (!empty($specialty)) {
    $query .= "JOIN hospital_specialties hs ON h.id = hs.hospital_id ";
}

$whereClause = [];
$params = [];
$types = "";

if (!empty($location)) {
    $whereClause[] = "h.location = ?";
    $params[] = $location;
    $types .= "s";
}

if (!empty($specialty)) {
    $whereClause[] = "hs.specialty = ?";
    $params[] = $specialty;
    $types .= "s";
}

if ($rating > 0) {
    $whereClause[] = "h.rating >= ?";
    $params[] = $rating;
    $types .= "i";
}
if (count($whereClause) > 0) {
    $query .= "WHERE " . implode(" AND ", $whereClause);
}

$query .= " ORDER BY h.name";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$hospitals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $hospitalId = $row['id'];
        $specQuery = "SELECT specialty FROM hospital_specialties WHERE hospital_id = ?";
        $specStmt = $conn->prepare($specQuery);
        $specStmt->bind_param("i", $hospitalId);
        $specStmt->execute();
        $specResult = $specStmt->get_result();
        
        $specialties = [];
        while ($specRow = $specResult->fetch_assoc()) {
            $specialties[] = $specRow['specialty'];
        }
        
        $row['specialties'] = $specialties;
        $hospitals[] = $row;
    }
}

$stmt->close();

if ($isAjax) {
    $response['hospitals'] = $hospitals;
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $_SESSION['filtered_hospitals'] = $hospitals;
    header('Location: home.html');
    exit;
}
?>
