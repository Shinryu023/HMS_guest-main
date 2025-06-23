<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CvSU - Silang Hotel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/g_design.css">
  <link rel="stylesheet" href="../css/home_text.css">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-2">
    <div class="container p-0">
      <!-- Brand/logo -->
      <a class="navbar-brand d-flex align-items-center me-4" href="#">
        <img src="../../resources/logos/cvsu_logo.png" alt="Logo" width="32" height="32" class="me-2"> <!-- insert logo -->
        <div style="line-height:1;">
          <strong style="font-size:1rem;">CvSU - Silang</strong><br>
          <small style="font-size:0.75rem;">Hotel Management System</small>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Navbar links centered -->
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link px-3" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#about">About Us</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#rooms">Rooms</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#amenities">Amenities</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#restaurant">Restaurant</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#booking">Booking</a></li>
        </ul>
        <!-- Guest Profile  -->
        <div class="d-flex align-items-center ms-auto">
          <div class="text-end me-2">
            <div class="fw-bold" style="font-size:0.95rem;">John Doe</div>
            <div class="small text-muted" style="font-size:0.8rem;">johndoe@gmail.com</div>
          </div>
          <img src="profile.jpg" alt="Profile Picture" class="rounded-circle" width="32" height="32">
        </div>
      </div>
    </div>
  </nav>

  <!-- Scrollable Sections -->
  <section id="home" class="home-banner-section py-5 text-center d-flex align-items-center justify-content-center" style="min-height:60vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h1 class="display-5 fw-bold text-white text-shadow">Welcome to CvSU - Silang Hotel!</h1>
          <p class="lead text-white text-shadow">
            Experience comfort, style, and exceptional service as our hotel offers modern rooms,
            top-tier amenities, and easy access to local attractions. Book now and make your stay unforgettable!
          </p>
          <a href="#about" class="btn btn-primary btn-lg">Get Started</a>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="py-5 d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0 text-center">
        <h2>Welcome to Your Home Away from Home</h2>
        <p>
          At CvSU - Silang Hotel, it’s our passion to serve for you. Our hotel offers a perfect blend of comfort, elegance, and service. 
          Whether you're visiting for business, leisure, or a special occasion, our goal is to make every stay memorable. <br><br>
          What sets us apart is our commitment to genuine care. Our dedicated team goes above and beyond to provide warm, attentive service, 
          ensuring every guest feels welcome and well taken care of. <br><br>
          We invite you to experience the perfect mix of charm, comfort, and quality. At CvSU - Silang Hotel, you're not just a guest but a valued member of our family.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img src="../img/about_section.jpg" alt="About Us" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</section>

  <section id="rooms" class="py-5 d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2>Our Rooms</h2>
          <p>
            Step into a world of comfort and elegance as you discover our thoughtfully designed rooms, each offering a unique blend of style, 
            warmth, and functionality. Whether you're seeking a peaceful retreat or a luxurious escape, our rooms provide the perfect setting for 
            relaxation and inspiration. From cozy deluxe rooms to fancy suite rooms, every detail is crafted to make you feel right at home. Start 
            your journey with us and uncover the perfect space tailored to your needs, your ideal stay begins the moment you walk through the door.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="../img/rooms_section.jpg" alt="Rooms" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <section id="services" class="py-5 d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2>Our Services</h2>
          <p>
            Experience hospitality redefined with our wide range of personalized services designed to make your stay effortless and memorable. 
            From seamless check-in and concierge assistance to room service and daily housekeeping, we take care of every detail so you can focus 
            on enjoying your time. Whether you're here for business or leisure, our attentive staff is always ready to meet your needs with warmth 
            and efficiency. Discover services that go beyond expectations—where comfort, care, and convenience come together.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="../img/services_section.jpg" alt="Services" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <section id="amenities" class="py-5 d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2>Amenities</h2>
          <p>
            Unwind, recharge, and indulge in the exceptional amenities that set our hotel apart. Take a dip in our serene pool, stay active in our 
            fully equipped fitness center, or savor delicious cuisine at our on-site restaurant. Complimentary high-speed Wi-Fi, business facilities, 
            and inviting lounge areas ensure both productivity and relaxation. Every amenity has been thoughtfully included to enhance your stay and 
            create a sense of effortless luxury. Discover the little extras that make a big difference.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="../img/amenities_section.jpg" alt="Amenities" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <section id="restaurant" class="py-5 d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2>Restaurant</h2>
          <p>
            Dine in style with our world-class restaurant menu.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="../img/restaurant_section.jpg" alt="Restaurant" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <section id="booking" class="py-5 d-flex align-items-center min-vh-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2>Book Your Stay</h2>
          <p>
            Have you found what you're looking for after exploring our rooms, services, and amenities? Experience unmatched comfort and personalized 
            service at our hotel. Book now to enjoy exclusive amenities, prime location, and a stay that feels like home with a touch of luxury. 
            Your perfect getaway starts here!
          </p>
          <a href="booking.php" class="btn btn-success btn-lg mt-3">Book Now</a>
        </div>
        <div class="col-lg-6 text-center">
          <img src="../img/booking_section.jpg" alt="Booking" class="img-fluid rounded shadow">
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scroll.js" defer></script>
</body>
</html>
