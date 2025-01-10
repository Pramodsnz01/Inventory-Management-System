<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard- Inventory Management System</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/users-add.css">
    <script src="https://kit.fontawesome.com/4d31e6f82d.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="dashboardmainContainer">
        <!-- sidebar -->
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <!-- topnav -->
            <?php include('partials/app-topnav.php') ?>
            <?php if (in_array('dashboard_view', $user['permissions'])) { ?>

                <div id="reportsContainer">
                    <div class="reportTypeContainer">
                        <div class="reportType">
                            <p>Export Products</p>
                            <div class="alignRight">
                                <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                                <a href="database/report_pdf.php?report=product" target="_blank"
                                    class="reportExportBtn">PDF</a>
                            </div>
                        </div>
                        <div class="reportType">
                            <p>Export Suppliers</p>
                            <div class="alignRight">
                                <a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
                                <a href="database/report_pdf.php?report=supplier" target="_blank"
                                    class="reportExportBtn">PDF</a>
                            </div>
                        </div>
                    </div>
                    <div class="reportTypeContainer">
                        <div class="reportType">
                            <p>Export Deliveries</p>
                            <div class="alignRight">
                                <a href="database/report_csv.php?report=delivery" class="reportExportBtn">Excel</a>
                                <a href="database/report_pdf.php?report=delivery" target="_blank"
                                    class="reportExportBtn">PDF</a>
                            </div>
                        </div>
                        <div class="reportType">
                            <p>Export Purchase Orders</p>
                            <div class="alignRight">
                                <a href="database/report_csv.php?report=purchase_orders" class="reportExportBtn">Excel</a>
                                <a href="database/report_pdf.php?report=purchase_orders" target="_blank"
                                    class="reportExportBtn">PDF</a>
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
    <script src="js/script.js"></script>

</body>

</html>