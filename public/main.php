<?php include_once '../model/globals.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System</title>

    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../view/components/input_box.css">
    <style>
        .outlined {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <div class="logo">
                <img src="../resources/logos/cvsu_logo.png" alt="Logo">
            </div>
            <div class="label">
                <p>CvSU-Silang</p>
                <p>Hotel Management System</p>
            </div>
        </div>
        <div class="navigation-container">

        </div>
        <div class="notif-container">
            <img src="../resources/icons/notification_icon.png" alt="N">
        </div>
        <div class="user-container">
            <div class="profile">
                <img src="../resources/icons/default_user_icon.png" alt="P">
            </div>
            <div class="name-container">
                <p class="name">John Doe</p>
                <p class="role">Admin</p>
                
            </div>
        </div>
    </div>
    <div class="main-container">
        <div class="sidebar-container">
            <?php
                $pages = ($user_role === "admin") ? $admin_pages : (($user_role === "staff") ? $staff_pages : []);

                if (!empty($pages)) {
                    echo '<div class="sidebar">';
                    foreach ($pages as $page_name => $page_link) {
                        $tab_class = ($current_page === $page_name) ? 'active-tab' : 'inactive-tab';
                        echo '<a href="?page=' . $page_name . '" class="tab ' . $tab_class . '">' . $page_name . '<span></span></a>';
                    }
                    echo '</div>';
                }
            ?>
        </div>
        <div class="main">
            <?php include $admin_pages[$current_page]; ?>
        </div>
    </div>
    <script src="../assets/js/service.js"></script>
</body>
</html>