<?php

$user_role = "admin";

$admin_pages = [
    "Dashboard" => "../view/pages/admin/dashboard.php",
    "Bookings" => "../view/pages/admin/bookings.php",
    "In-houses" => "../view/pages/admin/in-houses.php",
    "Orders" => "../view/pages/admin/orders.php",
    "Guests" => "../view/pages/admin/guests.php",
    "Calendar" => "../view/pages/admin/calendar.php",
    "Rooms" => "../view/pages/admin/rooms.php",
    "Amenities" => "../view/pages/admin/amenities.php",
    "Services" => "../view/pages/admin/services.php",
    "Restaurant" => "../view/pages/admin/restaurant.php",
    "POS" => "../view/pages/admin/pos.php",
    "Users" => "../view/pages/admin/users.php",
];
$current_page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';

?>