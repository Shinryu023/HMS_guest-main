<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/g_design.css" rel="stylesheet">
  <link href="../css/booking.css" rel="stylesheet">
  <style>
    .room-card.selected {
      border: 2px solid #ffc107; /* yellow highlight */
      box-shadow: 0 0 10px rgba(255,193,7,0.5);
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-2">
    <div class="container p-0">
      <a class="navbar-brand d-flex align-items-center me-4" href="home_g.php#home">
        <img src="../../resources/logos/cvsu_logo.png" alt="Logo" width="32" height="32" class="me-2">
        <div style="line-height:1;">
          <strong style="font-size:1rem;">CvSU - Silang</strong><br>
          <small style="font-size:0.75rem;">Hotel Management System</small>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link px-3" href="home_g.php#home">Home</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#rooms">Rooms</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#amenities">Amenities</a></li>
        </ul>
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
    
    <!-- Rooms -->
      <section id="rooms" class="py-5 min-vh-100">
  <div class="bg-dark text-white text-center py-5" style="background-image: url('https://via.placeholder.com/1200x300'); background-size: cover;">
    <h1 class="display-4">Rooms</h1>
  </div>

  <div class="container my-5">
    <div class="row">

      <!-- Filter Sidebar -->
      <div class="col-lg-3 mb-4">
        <div class="filter-box">
          <h5>Filter By</h5>
          <div class="mb-3">
            <label class="form-label">Price Range</label>
            <select class="form-select" id="filterPrice">
              <option value="all">All</option>
              <option value="0-20000">$0 - $20,000</option>
              <option value="20000-40000">$20,000 - $40,000</option>
              <option value="40000-60000">$40,000 - $60,000</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Size</label>
            <select class="form-select" id="filterSize">
              <option value="all">All</option>
              <option value="20">20m²</option>
              <option value="22">22m²</option>
              <option value="24">24m²</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Room Type</label>
            <select class="form-select" id="filterType">
              <option value="all">All</option>
              <option value="Deluxe Room">Deluxe Room</option>
              <option value="Single Room">Single Room</option>
              <option value="Standard Room">Standard Room</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Bed Type</label>
            <select class="form-select" id="filterBed">
              <option value="all">All</option>
              <option value="Royal Bed">Royal Bed</option>
              <option value="Single Bed">Single Bed</option>
              <option value="Queen Bed">Queen Bed</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Occupancy</label>
            <select class="form-select" id="filterOccupancy">
              <option value="all">All</option>
              <option value="1">1 guest</option>
              <option value="2">2 guests</option>
            </select>
          </div>
          <div class="d-flex justify-content-between">
            <button class="btn btn-link text-muted text-decoration-none p-0" onclick="clearFilters()">CLEAR</button>
            <button class="btn text-warning btn-sm" onclick="filterRooms()">APPLY</button>
          </div>
        </div>
      </div>

      <!-- Room Card Container -->
      <div class="col-lg-9">
        <div class="row">
          <div class="col-md-8" style="max-height: 600px; overflow-y: auto;">
            <h4>Rooms</h4>
            <div class="row g-4" id="roomsContainer">
              
            
            <!-- Room Cards -->
              <div class="col-md-4 room-card-wrapper" data-price="45000" data-size="22" data-type="Deluxe Room" data-bed="Royal Bed" data-occupancy="2">
                <div class="room-card p-2" data-name="Deluxe Room" data-size="22m²" data-bed="Royal Bed" data-guests="2 guests" data-price="45000" data-availability="5/10" data-description="Deluxe Room with elegant design and city view.">
                  <img src="https://via.placeholder.com/400x200" class="w-100" alt="Deluxe Room">
                  <div class="p-3">
                    <h5>Deluxe Room</h5>
                    <p class="small text-muted">22m² | Royal Bed | 2 guests</p>
                    <p class="price">$45,000/night</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 room-card-wrapper" data-price="20000" data-size="20" data-type="Single Room" data-bed="Single Bed" data-occupancy="1">
                <div class="room-card p-2" data-name="Single Room" data-size="20m²" data-bed="Single Bed" data-guests="1 guest" data-price="20000" data-availability="3/10" data-description="Cozy Single Room perfect for solo travelers.">
                  <img src="https://via.placeholder.com/400x200" class="w-100 rounded" alt="Single Room">
                  <div class="p-2">
                    <h5>Single Room</h5>
                    <p class="small text-muted">20m² | Single Bed | 1 guest</p>
                    <p class="price">$20,000/night</p>
                  </div>
                </div>
              </div>

              <div class="col-md-4 room-card-wrapper" data-price="15000" data-size="24" data-type="Standard Room" data-bed="Queen Bed" data-occupancy="2">
                <div class="room-card p-2" data-name="Standard Room" data-size="24m²" data-bed="Queen Bed" data-guests="2 guests" data-price="15000" data-availability="8/10" data-description="Comfortable Standard Room with modern amenities.">
                  <img src="https://via.placeholder.com/400x200" class="w-100" alt="Standard Room">
                  <div class="p-3">
                    <h5>Standard Room</h5>
                    <p class="small text-muted">24m² | Queen Bed | 2 guests</p>
                    <p class="price">$15,000/night</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Room Details -->
          <div class="col-md-4">
            <h4>Room Details</h4>
            <div id="roomDetails" class="p-3 border rounded" style="min-height:300px;">
              <p>Select a room to see details.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Services -->
    <section id="services" class="py-5 min-vh-100">
  <div class="bg-dark text-white text-center py-5" style="background-image: url('https://via.placeholder.com/1200x300'); background-size: cover;">
    <h1 class="display-4">Services</h1>
  </div>

  <div class="container my-5">
    <div class="row">

    <!-- Service Filter Sidebar -->
<div class="col-lg-3 mb-4">
  <div class="filter-box">
    <h5>Filter By</h5>
    <div class="mb-3">
      <label class="form-label">Price Range</label>
      <select class="form-select" id="filterServicePrice">
        <option value="all">All</option>
        <option value="100-300">$100 - $300</option>
        <option value="300-500">$300 - $500</option>
      </select>
    </div>
    <div class="d-flex justify-content-between">
      <button class="btn btn-link text-muted text-decoration-none p-0" onclick="clearServiceFilters()">CLEAR</button>
      <button class="btn text-warning btn-sm" onclick="filterServices()">APPLY</button>
    </div>
  </div>
</div>
<!-- Service Card Container -->
      <div class="col-lg-9">
        <div class="row">
          <div class="col-md-8" style="max-height: 600px; overflow-y: auto;">
            <h4>Services</h4>
            <div class="row g-4" id="servicesContainer">
    <!-- Service Cards -->
    
          <!-- More service cards here -->
        </div>
      </div>
      <!-- Service Details -->
      <div class="col-md-4">
        <h4>Service Details</h4>
        <div id="serviceDetails" class="p-3 border rounded" style="min-height: 200px;">
          <p>Select a service to see details.</p>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- Amenities -->
    <section id="amenities" class="py-5 min-vh-100">
  <div class="bg-dark text-white text-center py-5" style="background-image: url('https://via.placeholder.com/1200x300'); background-size: cover;">
    <h1 class="display-4">Amenities</h1>
  </div>

  <div class="container my-5">
    <div class="row">

    <!-- Amenities Filter Sidebar -->
<div class="col-lg-3 mb-4">
  <div class="filter-box">
    <h5>Filter By</h5>
    <div class="mb-3">
      <label class="form-label">Price Range</label>
      <select class="form-select" id="filterAmenitiesPrice">
        <option value="all">All</option>
        <option value="100-300">$100 - $300</option>
        <option value="300-500">$300 - $500</option>
      </select>
    </div>
    <div class="d-flex justify-content-between">
      <button class="btn btn-link text-muted text-decoration-none p-0" onclick="clearAmenitiesFilters()">CLEAR</button>
      <button class="btn text-warning btn-sm" onclick="filterAmenities()">APPLY</button>
    </div>
  </div>
</div>

<!-- Amenities Card Container -->
      <div class="col-lg-9">
        <div class="row">
          <div class="col-md-8" style="max-height: 600px; overflow-y: auto;">
            <h4>Amenities</h4>
            <div class="row g-4" id="amenitiesContainer">

    <!-- Amenities Card -->

          <!-- More amenity cards here -->
        </div>
      </div>
      <!-- Service Details -->
      <div class="col-md-4">
        <h4>Amenity Details</h4>
        <div id="amenityDetails" class="p-3 border rounded" style="min-height: 200px;">
          <p>Select an amenity to see details.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  //Room Filter  
  function filterRooms() {
    const price = document.getElementById('filterPrice').value;
    const size = document.getElementById('filterSize').value;
    const type = document.getElementById('filterType').value;
    const bed = document.getElementById('filterBed').value;
    const occupancy = document.getElementById('filterOccupancy').value;
    const rooms = document.querySelectorAll('.room-card-wrapper');

    rooms.forEach(room => {
      let show = true;
      const roomPrice = parseInt(room.dataset.price);
      const roomSize = room.dataset.size;
      const roomType = room.dataset.type;
      const roomBed = room.dataset.bed;
      const roomOccupancy = room.dataset.occupancy;

      if (price !== 'all') {
        const [min, max] = price.split('-');
        if (roomPrice < parseInt(min) || roomPrice > parseInt(max)) show = false;
      }
      if (size !== 'all' && size !== roomSize) show = false;
      if (type !== 'all' && type !== roomType) show = false;
      if (bed !== 'all' && bed !== roomBed) show = false;
      if (occupancy !== 'all' && occupancy !== roomOccupancy) show = false;

      room.style.display = show ? '' : 'none';
    });
  }

  function clearFilters() {
    document.getElementById('filterPrice').value = 'all';
    document.getElementById('filterSize').value = 'all';
    document.getElementById('filterType').value = 'all';
    document.getElementById('filterBed').value = 'all';
    document.getElementById('filterOccupancy').value = 'all';
    filterRooms();
  }
  //Service Filter
  function filterServices() {
  const price = document.getElementById('filterServicePrice').value;
  const services = document.querySelectorAll('.service-card-wrapper');
  services.forEach(service => {
    let show = true;
    const servicePrice = parseInt(service.querySelector('.service-card').dataset.price);
    if (price !== 'all') {
      const [min, max] = price.split('-');
      if (servicePrice < parseInt(min) || servicePrice > parseInt(max)) show = false;
    }
    service.style.display = show ? '' : 'none';
  });
}

function clearServiceFilters() {
  document.getElementById('filterServicePrice').value = 'all';
  filterServices();
}
  //Amenities Filter
  function filterAmenities() {
  const price = document.getElementById('filterAmenitiesPrice').value;
  const amenities = document.querySelectorAll('.amenity-card-wrapper'); // Corrected selector
  amenities.forEach(amenity => {
    let show = true;
    const amenityPrice = parseInt(amenity.querySelector('.amenity-card').dataset.price);
    if (price !== 'all') {
      const [min, max] = price.split('-');
      if (amenityPrice < parseInt(min) || amenityPrice > parseInt(max)) show = false;
    }
    amenity.style.display = show ? '' : 'none';
  });
}

function clearAmenitiesFilters() {
  document.getElementById('filterAmenitiesPrice').value = 'all';
  filterAmenities();
}

document.addEventListener('click', function(e) {
  // Room Card
  const roomCard = e.target.closest('.room-card');
  if(roomCard) {
    const isSelected = roomCard.classList.contains('selected');
    document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));

    if (!isSelected) {
      roomCard.classList.add('selected');
      const {name, size, bed, guests, price, availability, description} = roomCard.dataset;
      document.getElementById('roomDetails').innerHTML = `
        <h5>${name}</h5>
        <p>${size} | ${bed} | ${guests}</p>
        <p>Price: <strong>$${price}/night</strong></p>
        <p>Availability: ${availability}</p>
        <p>${description}</p>
        <div class="d-flex gap-2">
          <button class="btn btn-warning text-white btn-sm flex-fill rounded-pill book-now-btn">BOOK NOW</button>
          <button class="btn btn-outline-warning btn-sm flex-fill rounded-pill reserve-btn">RESERVE</button>
        </div>
      `;
    } else {
      document.getElementById('roomDetails').innerHTML = `<p>Select a room to see details.</p>`;
    }
    return;
  }

  // Service Card
  const serviceCard = e.target.closest('.service-card');
  if(serviceCard) {
    const isSelected = serviceCard.classList.contains('selected');
    document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));

    if (!isSelected) {
      serviceCard.classList.add('selected');
      const {name, description} = serviceCard.dataset;
      document.getElementById('serviceDetails').innerHTML = `
        <h5>${name}</h5>
        <p>${description}</p>
        <div class="d-flex gap-2">
          <button class="btn btn-warning text-white btn-sm flex-fill rounded-pill">Add Service</button>
          <button class="btn btn-outline-warning btn-sm flex-fill rounded-pill">No Thanks</button>
        </div>
      `;
    } else {
      document.getElementById('serviceDetails').innerHTML = `<p>Select a service to see details.</p>`;
    }
    return;
  }

  // Amenity Card
  const amenityCard = e.target.closest('.amenity-card');
  if(amenityCard) {
    const isSelected = amenityCard.classList.contains('selected');
    document.querySelectorAll('.amenity-card').forEach(c => c.classList.remove('selected'));

    if (!isSelected) {
      amenityCard.classList.add('selected');
      const {name, description} = amenityCard.dataset;
      document.getElementById('amenityDetails').innerHTML = `
        <h5>${name}</h5>
        <p>${description}</p>
        <div class="d-flex gap-2">
          <button class="btn btn-warning text-white btn-sm flex-fill rounded-pill">Add Amenity</button>
          <button class="btn btn-outline-warning btn-sm flex-fill rounded-pill">No Thanks</button>
        </div>
      `;
    } else {
      document.getElementById('amenityDetails').innerHTML = `<p>Select an amenity to see details.</p>`;
    }
    return;
  }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
