<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$hospital = null;
$specialties = [];

if ($id > 0) {
   
    $query = "SELECT * FROM hospitals WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $hospital = $result->fetch_assoc();
        
        $specQuery = "SELECT specialty FROM hospital_specialties WHERE hospital_id = ?";
        $specStmt = $conn->prepare($specQuery);
        $specStmt->bind_param("i", $id);
        $specStmt->execute();
        $specResult = $specStmt->get_result();
        
        while ($specRow = $specResult->fetch_assoc()) {
            $specialties[] = $specRow['specialty'];
        }
    }
    
    $stmt->close();
}

if (!$hospital) {
    header('Location: hospital.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($hospital['name']); ?> - Pure Health</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      body {
        font-family: 'Inter', sans-serif;
      }
      .bg{
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1;
        opacity: 0.4;
        object-fit: cover;
      }
      :root {
        --primary-blue: #2563eb;
        --light-blue: #eff6ff;
        --text-dark: #1e293b;
        --gradient-blue: linear-gradient(135deg, #2563ef 0%, #4f46e5 100%);
      }
     
      .navbar {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1000;
      }
      .navbar-brand {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--text-dark);
      }
      .navbar-nav {
        align-items: center;
      }
      .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease;
        margin: 0 10px;
      }
      .navbar-nav .nav-link::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -3px;
        width: 0;
        height: 2px;
        background-color: var(--primary-blue);
        transition: width 0.3s ease, left 0.3s ease;
      }
      .navbar-nav .nav-link:hover::after {
        width: 100%;
        left: 0;
      }
      .navbar-nav .nav-link.active {
        color: var(--primary-blue);
      }
     
      .btn-appointment {
        background: var(--primary-blue);
        color: white !important;
        border-radius: 50px;
        padding: 10px 20px;
        transition: transform 0.3s ease;
      }
      .btn-appointment:hover {
        background: var(--primary-blue);
        transform: translateY(-3px);
      }
      .btn-sign-in {
        background: transparent;
        color: var(--primary-blue) !important;
        border: 2px solid var(--primary-blue);
        border-radius: 50px;
        padding: 8px 18px;
        transition: all 0.3s ease;
      }
      .btn-sign-in:hover {
        background: var(--primary-blue);
        color: white !important;
        transform: translateY(-3px);
      }
      .navbar {
        position: sticky; 
        top: 0; 
        z-index: 100; 
      }
      .hero-detail {
        background: linear-gradient(rgba(58, 108, 245, 0.8), rgba(58, 108, 245, 0.8)), url('<?php echo htmlspecialchars($hospital['image_url']); ?>') no-repeat center center/cover;
        color: white;
        padding: 150px 0 80px;
      }
      .badge {
        background-color: #e6f0ff;
        color: #3a6cf5;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
        margin-right: 5px;
        margin-bottom: 5px;
      }
      .hospital-info {
        background: white;
        margin-top: -50px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 50px;
        padding: 30px;
      }
      .hospital-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 20px;
      }
      footer {
        background: #3a6cf5;
        color: white;
        padding: 40px 0;
      }
      footer a {
        color: white;
        text-decoration: none;
      }
      footer a:hover {
        text-decoration: underline;
        color: #e6f0ff;
      }
      .social-icon {
        display: inline-block;
        margin-right: 15px;
        font-size: 1.5rem;
      }
    </style>
</head>
<body>
    <img class="bg" src="hero.png" alt="Healthcare Background" />
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Pure Health</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="hospital.php">Hospitals</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="doctors.html">Doctors</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sign-in me-2" href="signup.html">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-appointment me-2" href="login.html">Login</a>
                    </li>
                    <li class="nav-item logout-item">
                <a class="btn btn-sign-in me-2" href="logout.php" >Logout</a>
            </li>
                    <li class="nav-item">
                        <a class="btn btn-appointment" href="appointment.html">Book Appointment</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold"><?php echo htmlspecialchars($hospital['name']); ?></h1>
                    <div class="mt-3">
                        <?php foreach ($specialties as $specialty): ?>
                            <span class="badge bg-light text-primary me-2"><?php echo htmlspecialchars($specialty); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <i class="fas fa-map-marker-alt me-2"></i> <?php echo htmlspecialchars($hospital['location']); ?>
                    </div>
                    <div class="mt-2">
                        <?php
                        $rating = $hospital['rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star text-warning"></i>';
                            } elseif ($i - 0.5 <= $rating) {
                                echo '<i class="fas fa-star-half-alt text-warning"></i>';
                            } else {
                                echo '<i class="far fa-star text-warning"></i>';
                            }
                        }
                        ?>
                        <span class="ms-2"><?php echo $hospital['rating']; ?> out of 5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="hospital-info">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="mb-4">About <?php echo htmlspecialchars($hospital['name']); ?></h2>
                    <p class="lead"><?php echo htmlspecialchars($hospital['description']); ?></p>
                    
                    <h4 class="mt-4 mb-3">Facilities</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> 24/7 Emergency Services</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Modern Diagnostic Equipment</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Comprehensive Treatment Plans</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Dedicated Patient Support</li>
                    </ul>
                    
                    <div class="mt-4">
                        <a href="appointment.html" class="btn btn-primary btn-lg">Book an Appointment</a>
                        <a href="tel:+5551234567" class="btn btn-outline-primary btn-lg ms-2"><i class="fas fa-phone me-2"></i> Contact</a>
                    </div>
                </div>
                <div class="col-md-5">
                    <img src="<?php echo htmlspecialchars($hospital['image_url']); ?>" alt="<?php echo htmlspecialchars($hospital['name']); ?>" class="hospital-image">
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Opening Hours</h5>
                            <div class="d-flex justify-content-between my-2">
                                <span>Monday - Friday</span>
                                <span>8:00 AM - 8:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between my-2">
                                <span>Saturday</span>
                                <span>9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between my-2">
                                <span>Sunday</span>
                                <span>10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i> Emergency services available 24/7
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Pure Health</h5>
                    <p>Innovative healthcare solutions</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                    <li><a href="home.html" class="text-white">Home</a></li>
                    <li><a href="hospital.php" class="text-white">Hospitals</a></li>
                    <li><a href="doctors.html" class="text-white">Doctors</a></li>
                    <li><a href="about.html" class="text-white">About Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact Us</h5>
                    <p>123 Healthcare Street<br />Wellness City</p>
                    <p>Phone: (555) 123-4567</p>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
