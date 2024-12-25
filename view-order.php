<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$show_table = 'suppliers';
// Fetch all users from database
$suppliers = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Purchase Orders- Inventory Management System</title>
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
                            <h1 class="section_header"><i class="fa fa-list"></i> List of Purchase Orders</h1>
                            <div class="section_content">
                                <div class="poListContainer">
                                    <div class="poList">
                                        <p>Batch #: 1735096566</p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Product</th>
                                                    <th>Qty Ordered</th>
                                                    <th>Supplier</th>
                                                    <th>Status</th>
                                                    <th>Ordered By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="poBtnContainer alignRight">
                                            <button class="appbtn updatepoBtn">Update</button>
                                        </div>
                                    </div> 
                                    <div class="poList">
                                        <p>Batch #: 1735096566</p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Product</th>
                                                    <th>Qty Ordered</th>
                                                    <th>Supplier</th>
                                                    <th>Status</th>
                                                    <th>Ordered By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="poBtnContainer alignRight">
                                            <button class="appbtn updatepoBtn">Update</button>
                                        </div>
                                    </div> 
                                    <div class="poList">
                                        <p>Batch #: 1735096566</p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Product</th>
                                                    <th>Qty Ordered</th>
                                                    <th>Supplier</th>
                                                    <th>Status</th>
                                                    <th>Ordered By</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Product</td>
                                                    <td>Qty Ordered</td>
                                                    <td>Supplier</td>
                                                    <td>Status</td>
                                                    <td>Ordered By</td>
                                                    <td>Created At</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="poBtnContainer alignRight">
                                            <button class="appbtn updatepoBtn">Update</button>
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('partials/app-scripts.php'); ?>

    <script>

        function script() {
            var vm = this;

            this.registerEvents = function () {
            },

                this.initialize = function () {
                    this.registerEvents();
                };
        }

        var script = new script();
        script.initialize();
    </script>


</body>

</html>