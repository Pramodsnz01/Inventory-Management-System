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
                                    <?php  
                                        $stmt = $conn->prepare("SELECT products.product_name, order_product.quantity_ordered, users.first_name, users.last_name, order_product.batch,  suppliers.supplier_name, order_product.status, order_product.created_at FROM order_product, suppliers, products, users WHERE
                                        order_product.supplier = suppliers.id 
                                        AND order_product.product = products.id 
                                        AND order_product.created_by = users.id
                                        ORDER BY order_product.created_at DESC");

                                        $stmt->execute();
                                        $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                                        
                                        $data = [];
                                        foreach($purchase_orders as $purchase_order){
                                            $data[$purchase_order['batch']][] = $purchase_order; 
                                        } 
                                    ?>
                                    <?php 
                                        foreach($data as $batch_id => $batch_pos){
                                    ?>
                                    <div class="poList">
                                        <p>Batch #: <?= $batch_id ?></p>
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
                                                <?php 
                                                    foreach($batch_pos as $index => $batch_po){

                                                ?>
                                                <tr>
                                                    <td><?= $index + 1 ?> </td>
                                                    <td><?= $batch_po['product_name'] ?></td>
                                                    <td><?= $batch_po['quantity_ordered'] ?></td>
                                                    <td><?= $batch_po['supplier_name'] ?></td>
                                                    <td><span class="po-badge po-badge-<?= $batch_po['status'] ?>"><?= $batch_po['status'] ?></span></td>
                                                    <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name'] ?></td>
                                                    <td><?= $batch_po['created_at'] ?></td>
                                                </tr> 
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="poBtnContainer alignRight">
                                            <button class="appbtn updatepoBtn">Update</button>
                                        </div>
                                    </div>
                                    <?php } ?>  
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