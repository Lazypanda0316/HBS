<?php 
session_start();
if(!isset($_COOKIE['UNAME'])){
    header("Location: login.php");
    die(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Rooms Details</title>
    <link href="css/rooms.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include "navigation.php"; ?>
    </header>
    <div class="container">
        <div class="room-poster">
            <img src="images/sd.jpg" alt="Super Deluxe Room">
            <div class="room-title">
                <h3>SUPER DELUXE ROOM</h3>
                <p>
                    <strong>What it Offers:</strong> The ultimate in luxury and comfort.<br>
                    <strong>Features:</strong> Spacious, elegant, and meticulously decorated.<br>
                    <strong>Comfort Level:</strong> Plush bedding ensures a cozy night's sleep.<br>
                    <strong>Convenience:</strong> Equipped with modern amenities like high-speed internet and flat-screen TVs.<br>
                    <strong>Service:</strong> Dedicated staff ensures your needs are met with exceptional care.
                </p>
            </div>
           
        </div>
    </div>

    <div class="container">
        <div class="room-poster">
            <img src="images/delux.jpg" alt="Deluxe Room">
            <div class="room-title">
                <h3>DELUXE ROOM</h3>
                <p>
                    <strong>What it Offers:</strong> A blend of elegance and modern comfort.<br>
                    <strong>Features:</strong> Stylish interiors, ambient lighting, and premium furnishings.<br>
                    <strong>Comfort Level:</strong> Luxurious king-sized bed with high-quality linens.<br>
                    <strong>Convenience:</strong> Includes high-speed Wi-Fi, a smart TV, and a well-stocked minibar.<br>
                    <strong>Service:</strong> Personalized service with 24/7 room assistance and daily housekeeping.
                </p>
            </div>
          
        </div>
    </div>

    <div class="container">
        <div class="room-poster">
            <img src="images/suite.jpg" alt="Suite Room">
            <div class="room-title">
                <h3>SUITE ROOM</h3>
                <p>
                    <strong>What it Offers:</strong> The pinnacle of luxury and sophistication.<br>
                    <strong>Features:</strong> Expansive living space, elegant decor, and panoramic city views.<br>
                    <strong>Comfort Level:</strong> Separate living and sleeping areas with a plush king-sized bed.<br>
                    <strong>Convenience:</strong> Includes high-speed Wi-Fi, multiple smart TVs, and a premium minibar.<br>
                    <strong>Service:</strong> Exclusive access to concierge services and personalized butler service.
                </p>
            </div>
            
        </div>
    </div>

    <div class="container">
        <div class="room-poster">
            <img src="images/standard.jpg" alt="Standard Room">
            <div class="room-title">
                <h3>STANDARD ROOM</h3>
                <p>
                    <strong>What it Offers:</strong> Comfortable and affordable accommodation.<br>
                    <strong>Features:</strong> Cozy and practical design with essential furnishings.<br>
                    <strong>Comfort Level:</strong> Comfortable queen-sized bed with fresh linens.<br>
                    <strong>Convenience:</strong> Includes complimentary Wi-Fi, a flat-screen TV, and a work desk.<br>
                    <strong>Service:</strong> Daily housekeeping and 24/7 front desk support.
                </p>
            </div>
           
        </div>
    </div>

    <div class="container">
        <div class="room-poster">
            <img src="images/image.png" alt="Club Room">
            <div class="room-title">
                <h3>CLUB ROOM</h3>
                <p>
                    <strong>What it Offers:</strong> An elevated stay with exclusive benefits and access.<br>
                    <strong>Features:</strong> Modern decor, stylish furnishings, and premium amenities.<br>
                    <strong>Comfort Level:</strong> Luxurious king-sized bed with premium bedding.<br>
                    <strong>Convenience:</strong> Includes high-speed Wi-Fi, a large smart TV, and a Nespresso coffee machine.<br>
                    <strong>Service:</strong> Access to the exclusive Club Lounge, complimentary breakfast, and evening cocktails.<br>
                    <strong>Extras:</strong> Priority check-in and check-out, and personalized concierge service.
                </p>
            
        </div>
    </div>

 <?php include "footer.php"?>
</body>
</html>
