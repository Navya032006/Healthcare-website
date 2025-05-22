<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to book an appointment']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "health care";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->select_db($database);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating users table: " . $conn->error);
}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$requiredFields = ['first_name', 'last_name', 'email', 'phone', 'specialty', 'doctor', 'appointment_date', 'appointment_time'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        echo json_encode(['status' => 'error', 'message' => "Field '$field' is required"]);
        exit;
    }
}

$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    dob DATE,
    gender VARCHAR(10),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    zip VARCHAR(20),
    specialty VARCHAR(100) NOT NULL,
    doctor VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(20) NOT NULL,
    notes TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql)) {
    echo json_encode(['status' => 'error', 'message' => 'Error creating appointments table: ' . $conn->error]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO appointments (
    user_id, first_name, last_name, email, phone, dob, gender, address, 
    city, state, zip, specialty, doctor, appointment_date, appointment_time, notes
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$userId = $_SESSION['user_id'];
$dob = !empty($data['dob']) ? $data['dob'] : null;
$gender = !empty($data['gender']) ? $data['gender'] : null;
$address = !empty($data['address']) ? $data['address'] : null;
$city = !empty($data['city']) ? $data['city'] : null;
$state = !empty($data['state']) ? $data['state'] : null;
$zip = !empty($data['zip']) ? $data['zip'] : null;
$notes = !empty($data['notes']) ? $data['notes'] : null;

$stmt->bind_param("isssssssssssssss", 
    $userId,
    $data['first_name'],
    $data['last_name'],
    $data['email'],
    $data['phone'],
    $dob,
    $gender,
    $address,
    $city,
    $state,
    $zip,
    $data['specialty'],
    $data['doctor'],
    $data['appointment_date'],
    $data['appointment_time'],
    $notes
);

if ($stmt->execute()) {
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Appointment booked successfully',
        'appointment_id' => $conn->insert_id
    ]);
} else {
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Error booking appointment: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close(); 
?>