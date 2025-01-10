<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$_SESSION['table'] = 'products';
$_SESSION['redirect_to'] = 'product-add.php';

// Fetch user data from session
$show_table = 'products';
// Fetch all users from database
$users = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product- Inventory Management System</title>
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
                <?php if (in_array('product_create', $user['permissions'])) { ?>
                    
                    <div class="dashboardContent_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-plus"></i> Create Product</h1>
                                <div class="useraddFormContainer">
                                    <form action="database/add.php" method="POST" class="appForm"
                                        enctype="multipart/form-data">
                                        <div class="appFormInputContainer">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" id="product_name" placeholder="Enter the product name..."
                                                class="appFormInput" name="product_name" />
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="description">Description</label>
                                            <textarea id="description" placeholder="Give product short description..."
                                                class="appFormInput productTextAreaInput" name="description"></textarea>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="description">Suppliers</label>
                                            <select name="suppliers[]" id="suppliersSelect" multiple>
                                                <option value="">Select Supplier</option>
                                                <?php
                                                $show_table = 'suppliers';
                                                $suppliers = include('database/show.php');

                                                foreach ($suppliers as $supplier) {
                                                    echo "<option value='" . $supplier['id'] . "'> " . $supplier['supplier_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="appFormInputContainer">
                                            <label for="img">Product Image</label>
                                            <input type="file" id="img" class=" " name="img" />
                                        </div>
                                        <button type="submit" class="appbtn"><i class="fa fa-plus"></i> Create
                                            Product</button>
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
                <?php } else { ?>
                    <div id="errorMessage">You do not have permission to view this page.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>
</body>

</html>