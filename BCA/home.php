<?php 
session_start();
if(!isset($_SESSION['UNAME'])) {
    header("Location: login.php");
    exit();
}?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ARCH ANGEL System</title>
  <link href="css/home.css" rel="stylesheet">
</head>
<body>
<?php 
    include "navigation.php";
    ?>
  <section class="paragraph">
    <h1>WELCOME TO ARCH ANGEL</h1>
  
    <div class="photo-container">
      <div class="card">
        <div class="photo">
          <img src="images/backgroun.jpg" alt="Photo 1">
        </div>
        <p>Welcome to our online booking website, your one-stop destination for hassle-free reservations!</p>
      </div>
    </div>
  </section>

  <section class="hero">
    <div class="hero-content">
      <h2>Book Your Stay with Us</h2>
      <p>Experience comfort and luxury at our hotel. Book your room now!<br><br></p>
      <a href="booking.php" class="btn">Book Now</a>
    </div>
  </section>

  <section class="features">
    <div class="feature">
      <h3>Comfortable Rooms</h3>
      <p>Our hotel offers spacious and well-equipped rooms to ensure your comfort during your stay. These spaces are designed with the intention of providing a serene and inviting atmosphere for occupants. They typically feature cozy furnishings, soft lighting, and thoughtful decor that promotes a feeling of warmth and tranquility. Whether it's a bedroom, living room, or any other area, comfortable rooms prioritize comfort and well-being, encouraging people to unwind, recharge, and feel at home.<br><br></p>
    </div>
    <div class="feature">
    <h3>Great Services</h3>
  <div class="service-image">
    <img src="images/service.jpg" alt="facility">
  </div>
  <div class="service-description">
    <p><br><br>Step into a world of unparalleled luxury at ARCH ANGEL, where every detail is crafted to exceed your expectations. From personalized room service delivering exquisite cuisine at any hour, to meticulous housekeeping ensuring your comfort is always pristine. Our expert concierge service stands ready to curate bespoke experiences, guiding you through the city's finest offerings. Immerse yourself in tranquility with our spa and wellness amenities, designed to rejuvenate body and soul. Whether you're here for business or pleasure, our comprehensive services cater to your every need, ensuring a stay that is as seamless as it is unforgettable.<br><br></p>
  </div>

   <div class="feature">
  <h3>Prime Location</h3>
  </div>
  <div class="location-description">
    <p>Discover ARCH ANGEL, ideally situated in the vibrant heart of the city, offering unparalleled access to iconic landmarks, cultural hotspots, and thriving business centers. Whether you're here to explore historic sites, indulge in world-class dining, or attend business meetings, our central location ensures convenience and connectivity. Enjoy seamless travel with proximity to major transportation hubs, ensuring effortless exploration of everything our dynamic city has to offer. Embrace the pulse of urban life from the comfort of our exceptional hotel, where every journey begins and ends with unparalleled convenience and luxury.</p>
  </div>
</div>

  </section>

  <?php include "footer.php"?>
</body>
</html>
