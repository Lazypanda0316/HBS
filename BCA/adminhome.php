<?php 

session_start();
if(!isset($_SESSION['UNAME'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - ARCH ANGEL System</title>
  <link href="css/adminhome.css" rel="stylesheet">
</head>
<body>
<?php include "adminnav.php" ?>

<div class="main-content">
  <h1>Welcome to the Admin Dashboard</h1>
  <div class="para">
  
  <div class="card-container">
    <div class="card">
      <img src="images/backgroun.jpg" alt="Manage Bookings">
      <h3>Manage Bookings</h3>
      <p>Oversee all current and upcoming bookings. Make changes, cancellations, or new reservations with ease.</p>
      <a href="admin.php" class="btn">Go to Bookings</a>
    </div>
    
    <div class="card">
      <img src="images/service.jpg" alt="View Reports">
      <h3>View Reviews</h3>
      <p>Access detailed reports on bookings, revenue, and user activity. Make informed decisions with comprehensive data.</p>
      <a href="viewadmin.php" class="btn">Go to Reports</a>
    </div>
  </div>
</div>


</body>
</html>
