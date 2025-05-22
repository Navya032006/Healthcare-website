<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health care";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $question = $_POST['question'];

    $stmt = $conn->prepare("INSERT INTO questions (name, email, question, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $email, $question);

    $response = array();
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Your question has been submitted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to submit your question. Please try again.';
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
