<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Please login first.');
            window.location.href = 'login.html'; // or your actual login page
          </script>";
    exit();
}
session_destroy();
?>
<script>
    alert("You have been logged out successfully.");
    window.location.href = "home.html";
  </script>
</body>
</html>


