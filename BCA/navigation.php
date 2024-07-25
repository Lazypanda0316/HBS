<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/navigation.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="pic"><img src="images/acr2.png" alt="logo"></div>
        <nav>
            <ul>
                <li><a href="home.php" class="link">Home</a></li>
                <li><a href="rooms.php" class="link">Rooms</a></li>
                <li><a href="booking.php" class="link">Bookings</a></li>
                <li><a href="mybooking.php" class="link">My Bookings</a></li>
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div class="dropdown-content">
                        <li><a href="dashbord.php" class="link"><?php echo $_SESSION['UNAME']."'s Dashboard";?></a></li>
                        <li><a href="aboutus.php" class="link">About us</a></li>
                        <li><a href="reviews.php" class="link">Reviews</a></li>
                        <li><a href="logout.php" class="link">Logout</a></li>
                    </div>
                </div>
            </ul>
        </nav>
    </div>
  </body>
</html>
