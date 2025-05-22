<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "health care";
$port = 3307;

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function setupDatabase($conn) {
    
    $sql = "CREATE TABLE IF NOT EXISTS hospitals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        location VARCHAR(100) NOT NULL,
        rating DECIMAL(2,1) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if (!$conn->query($sql)) {
        echo "Error creating hospitals table: " . $conn->error;
        return false;
    }
    
    $sql = "CREATE TABLE IF NOT EXISTS hospital_specialties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hospital_id INT NOT NULL,
        specialty VARCHAR(100) NOT NULL,
        FOREIGN KEY (hospital_id) REFERENCES hospitals(id) ON DELETE CASCADE
    )";
    
    if (!$conn->query($sql)) {
        echo "Error creating hospital_specialties table: " . $conn->error;
        return false;
    }
    
    $result = $conn->query("SELECT COUNT(*) as count FROM hospitals");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        
        $hospitals = [
            [
                'name' => 'City Heart Hospital',
                'description' => 'A leading heart-care center with state-of-the-art facilities and experienced doctors specializing in cardiovascular treatments.',
                'location' => 'Mangalagiri',
                'rating' => 5.0,
                'image_url' => 'cityheart.png',
                'specialties' => ['Cardiology', 'Vascular Surgery']
            ],
            [
                'name' => 'Greenlife Multi-Specialty',
                'description' => '24/7 services in cardiology, neurology, orthopedics, and emergency medicine with a focus on personalized care.',
                'location' => 'Guntur',
                'rating' => 4.5,
                'image_url' => 'greenlife.png',
                'specialties' => ['Neurology', 'Orthopedics']
            ],
            [
                'name' => 'Sunshine Children\'s Hospital',
                'description' => 'Specialized care for children of all ages with modern facilities and child-friendly environment for better recovery.',
                'location' => 'Vijayawada',
                'rating' => 5.0,
                'image_url' => 'sunshine.png',
                'specialties' => ['Pediatrics', 'Child Psychology']
            ],
            [
                'name' => 'Metro General Hospital',
                'description' => 'Comprehensive healthcare services for all age groups with advanced diagnostic and therapeutic facilities round the clock.',
                'location' => 'Bapatla',
                'rating' => 4.0,
                'image_url' => 'metro.png',
                'specialties' => ['General Medicine', 'Surgery']
            ],
            [
                'name' => 'Hope Cancer Institute',
                'description' => 'Dedicated to cancer care with cutting-edge treatment protocols, supportive therapies and personalized recovery plans.',
                'location' => 'Tenali',
                'rating' => 4.5,
                'image_url' => 'hope.png',
                'specialties' => ['Oncology', 'Radiation Therapy']
            ],
            [
                'name' => 'Joint & Spine Care Center',
                'description' => 'Specializing in orthopedic conditions with advanced surgical techniques, sports medicine, and comprehensive rehabilitation programs.',
                'location' => 'Ongole',
                'rating' => 4.0,
                'image_url' => 'joint.png',
                'specialties' => ['Orthopedics', 'Physical Therapy']
            ]
        ];
        
        foreach ($hospitals as $hospital) {
            $stmt = $conn->prepare("INSERT INTO hospitals (name, description, location, rating, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssds", $hospital['name'], $hospital['description'], $hospital['location'], $hospital['rating'], $hospital['image_url']);
            
            if ($stmt->execute()) {
                $hospital_id = $conn->insert_id;
                
                foreach ($hospital['specialties'] as $specialty) {
                    $specStmt = $conn->prepare("INSERT INTO hospital_specialties (hospital_id, specialty) VALUES (?, ?)");
                    $specStmt->bind_param("is", $hospital_id, $specialty);
                    $specStmt->execute();
                    $specStmt->close();
                }
            }
            
            $stmt->close();
        }
    }
    
    return true;
}

 setupDatabase($conn);
?>
