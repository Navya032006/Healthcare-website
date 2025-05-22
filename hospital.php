<?php
session_start();

require_once 'db.php';
$query = "SELECT * FROM hospitals ORDER BY name";
$result = $conn->query($query);
$hospitals = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hospitals[] = $row;
    }
}

$locationsQuery = "SELECT DISTINCT location FROM hospitals ORDER BY location";
$locationsResult = $conn->query($locationsQuery);
$locations = [];

if ($locationsResult && $locationsResult->num_rows > 0) {
    while ($row = $locationsResult->fetch_assoc()) {
        $locations[] = $row['location'];
    }
}

$specialtiesQuery = "SELECT DISTINCT specialty FROM hospital_specialties ORDER BY specialty";
$specialtiesResult = $conn->query($specialtiesQuery);
$specialties = [];

if ($specialtiesResult && $specialtiesResult->num_rows > 0) {
    while ($row = $specialtiesResult->fetch_assoc()) {
        $specialties[] = $row['specialty'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pure Health - Hospital Finder</title>
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
      .hero h1{
        font-weight: bolder;
      }
      .hero {
        background: linear-gradient(rgba(58, 108, 245, 0.8));
        color: white;
        text-align: center;
        padding: 100px 20px;
      }
      .filter-bar {
        background: white;
        margin-top: -50px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 50px;
      }
      .card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }
      .card:hover {
        transform: translateY(-5px);
      }
      .card img {
        height: 200px;
        object-fit: cover;
      }
      .card-title {
        font-weight: 600;
        color: #1a2b49;
      }
      .card-text {
        color: #666;
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
      .loading {
        text-align: center;
        padding: 50px 0;
      }
    </style>
</head>
<body>
    <img class="bg" src="hero.png" alt="Healthcare Background" />
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Pure Health</a>
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

    <div class="hero">
        <h1>Our Network of Hospitals</h1>
        <p class="mt-3 fs-5">Discover world-class healthcare facilities committed to excellence in patient care</p>
    </div>

    <div class="container filter-bar">
        <form id="filterForm" method="post">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="location" class="form-label">Location</label>
                    <select id="location" name="location" class="form-select">
                        <option value="">All Locations</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?php echo htmlspecialchars($location); ?>">
                                <?php echo htmlspecialchars($location); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="specialty" class="form-label">Specialty</label>
                    <select id="specialty" name="specialty" class="form-select">
                        <option value="">All Specialties</option>
                        <?php foreach ($specialties as $specialty): ?>
                            <option value="<?php echo htmlspecialchars($specialty); ?>">
                                <?php echo htmlspecialchars($specialty); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="rating" class="form-label">Rating</label>
                    <select id="rating" name="rating" class="form-select">
                        <option value="">Any Rating</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars & Up</option>
                        <option value="3">3 Stars & Up</option>
                    </select>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-filter me-2"></i>Filter Results
                </button>
            </div>
        </form>
    </div>

    <div class="container pb-5">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-center">All Hospitals</h2>
                <p class="text-center text-muted">Find the perfect hospital for your healthcare needs</p>
            </div>
        </div>

        <div class="row g-4" id="hospitalsContainer">
            <?php if (count($hospitals) > 0): ?>
                <?php foreach ($hospitals as $hospital): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($hospital['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($hospital['name']); ?>" />
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($hospital['name']); ?></h5>
                                <div class="mb-2">
                                    <?php
                                    
                                    $hospitalId = $hospital['id'];
                                    $specQuery = "SELECT specialty FROM hospital_specialties WHERE hospital_id = $hospitalId";
                                    $specResult = $conn->query($specQuery);
                                    
                                    if ($specResult && $specResult->num_rows > 0) {
                                        while ($specRow = $specResult->fetch_assoc()) {
                                            echo '<span class="badge">' . htmlspecialchars($specRow['specialty']) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <p class="card-text"><?php echo htmlspecialchars($hospital['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        <span class="ms-1"><?php echo htmlspecialchars($hospital['location']); ?></span>
                                    </div>
                                    <div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="hospital_details.php?id=<?php echo $hospital['id']; ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No hospitals found matching your criteria. Please try different filters.</div>
                </div>
            <?php endif; ?>
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
    <script src="script.js"></script>
</body>
</html>
