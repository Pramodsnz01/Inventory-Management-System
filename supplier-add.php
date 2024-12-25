<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$_SESSION['table'] = 'suppliers';
$_SESSION['redirect_to'] = 'supplier-add.php';

// Fetch user data from session
$show_table =  'products';
// Fetch all users from database
$users = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier- Inventory Management System</title> 
    <?php include('partials/app-header-scripts.php'); ?>
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
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fa fa-plus"></i> Create Supplier</h1>
                            <div class="useraddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                                    <div class="appFormInputContainer">
                                        <label for="supplier_name">Supplier Name</label>
                                        <input type="text" id="supplier_name" placeholder="Enter the supplier name..." class="appFormInput" name="supplier_name" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="supplier_location">Location</label>
                                        <input type="text" id="supplier_location" placeholder="Give product supplier location..." class="appFormInput" name="supplier_location"></input> 
                                    </div> 
                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" placeholder="Give product supplier email..." class="appFormInput" name="email"></input> 
                                    </div> 
                                    <button type="submit" class="appbtn"><i class="fa fa-plus"></i> Create Product</button>
                                </form>
                                <?php
                                if (isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                                    ?>
                                    <div class="responseMessage">
                                        <p
                                            class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?> ">
                                            <?= $response_message ?>
                                        </p>
                                    </div>
                                    <?php unset($_SESSION['response']);
                                } ?>
                            </div>

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>
</body>
</html>