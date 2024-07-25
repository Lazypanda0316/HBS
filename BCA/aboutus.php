<?php 
session_start();
if (!isset($_COOKIE['UNAME'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Arch-Angel Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/aboutus.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include "navigation.php"; ?>
    </header>

    <div class="content">
        <div class="hero">
            <img src="images/background.jpg" alt="Background Image">
            <h2>NAMASTE</h2>
        </div>
        <div class="text">
            <p>ARCH ANGEL is a luxurious hotel located in the heart of the city. With our world-class amenities and exceptional service, we strive to make your stay with us unforgettable. Our hotel features spacious and elegantly decorated rooms, a rooftop restaurant with panoramic views, a fully equipped fitness center, and a relaxing spa. Whether you're traveling for business or leisure, Hotel ARCH ANGEL offers everything you need for a comfortable and enjoyable stay. At Arch Angel, we are committed to providing our guests with the highest level of hospitality and personalized service. Our dedicated staff is here to assist you with any requests and ensure that your stay exceeds your expectations.</p>
        </div>

        <div class="additional-content">
            <h3>Our Amenities</h3>
            <p>Enjoy our state-of-the-art fitness center, rejuvenating spa services, and a rooftop pool with stunning views. Our on-site restaurant serves gourmet meals prepared by top chefs, and our lounge offers a perfect setting for relaxation and socializing.</p>

            <h3>Our Commitment</h3>
            <p>At ARCH ANGEL, we are dedicated to sustainability and environmental responsibility. We employ eco-friendly practices and strive to minimize our carbon footprint while providing exceptional service and luxury to our guests.</p>

            <h3>Contact Us</h3>
            <p>If you have any questions or need assistance, please do not hesitate to contact our front desk or concierge service. We are here to ensure that your stay is comfortable and memorable.<br>
                Contact: 01-5433322, +977-9838912342, +977-9803389704<br>
                E-mail: archangel@gmail.com

            </p>
        </div>
    </div>

    
        <?php include "footer.php"; ?>
  
</body>
</html>
