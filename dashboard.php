<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data from session
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard- Inventory Management System</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://kit.fontawesome.com/4d31e6f82d.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="dashboardmainContainer">
         <!-- sidebar -->
         <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
             <!-- topnav -->
           <?php include('partials/app-topnav.php') ?>
            <div class="dashboard_content">
                <div class="dashboardContent_main">
                    <!-- Dashboard content goes here -->
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
