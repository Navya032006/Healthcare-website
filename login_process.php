<?php
session_start();

header('Content-Type: application/json');

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    
    if (strpos($contentType, 'application/json') !== false) {
        
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        $email = $conn->real_escape_string($data['email']);
        $password = $data['password'];
    } else {
        
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    }
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            
            $response = [
                "status" => "success",
                "message" => "Login successful.",
                "user" => [
                    "id" => $user['id'],
                    "name" => $user['first_name'] . ' ' . $user['last_name'],
                    "email" => $user['email']
                ]
            ];
        } else {
            
            $response = [
                "status" => "error",
                "message" => "Invalid password. Please try again."
            ];
        }
    } else {
       
        $response = [
            "status" => "error",
            "message" => "Email not found. Please check your email or sign up."
        ];
    }
    
   
    echo json_encode($response);
}

$conn->close();
?>