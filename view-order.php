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
                                    $stmt = $conn->prepare("SELECT order_product.id, order_product.product, products.product_name, order_product.quantity_received, order_product.quantity_ordered, users.first_name, users.last_name, order_product.batch,  suppliers.supplier_name, order_product.status, order_product.created_at FROM order_product, suppliers, products, users WHERE
                                        order_product.supplier = suppliers.id 
                                        AND order_product.product = products.id 
                                        AND order_product.created_by = users.id
                                        ORDER BY order_product.created_at DESC");

                                    $stmt->execute();
                                    $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    $data = [];
                                    foreach ($purchase_orders as $purchase_order) {
                                        $data[$purchase_order['batch']][] = $purchase_order;
                                    }
                                    ?>
                                    <?php
                                    foreach ($data as $batch_id => $batch_pos) {
                                        ?>
                                        <div class="poList" id="container-<?= $batch_id ?>">
                                            <p>Batch #: <?= $batch_id ?></p>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Product</th>
                                                        <th>Qty Ordered</th>
                                                        <th>Qty Received</th>
                                                        <th>Supplier</th>
                                                        <th>Status</th>
                                                        <th>Ordered By</th>
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($batch_pos as $index => $batch_po) {

                                                        ?>
                                                        <tr>
                                                            <td><?= $index + 1 ?> </td>
                                                            <td class="po_product"><?= $batch_po['product_name'] ?></td>
                                                            <td class="po_qty_ordered"><?= $batch_po['quantity_ordered'] ?></td>
                                                            <td class="po_qty_received"><?= $batch_po['quantity_received'] ?>
                                                            </td>
                                                            <td class="po_qty_supplier"><?= $batch_po['supplier_name'] ?></td>
                                                            <td class="po_qty_status"><span
                                                                    class="po-badge  po-badge-<?= $batch_po['status'] ?>"><?= $batch_po['status'] ?></span>
                                                            </td>
                                                            <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $batch_po['created_at'] ?>
                                                                <input type="hidden" class="po_qty_row_id"
                                                                    value="<?= $batch_po['id'] ?>">
                                                                <input type="hidden" class="po_qty_productid"
                                                                    value="<?= $batch_po['product'] ?>">
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div class="poBtnContainer alignRight">
                                                <button class="appbtn updatepoBtn"
                                                    data-id="<?= $batch_id ?>">Update</button>
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
                document.addEventListener('click', function (e) {
                    let targetElement = e.target;
                    let classList = targetElement.classList;

                    if (classList.contains('updatepoBtn')) {
                        e.preventDefault(); 

                        let batchNumber = targetElement.dataset.id;
                        let batchNumberContainer = 'container-' + batchNumber;
                        //Get all the purchase order product records 
                        
                        productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
                        qtyOrderedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
                        qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
                        supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
                        statusList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_status');
                        rowIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_row_id'); 
                        pIds = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_productid'); 

                        poListArr =[] ;
                        for(i=0; i<productList.length; i++) {
                            poListArr.push({ 
                                name: productList[i].innerText,
                                qtyOrdered: qtyOrderedList[i].innerText,
                                qtyReceived: qtyReceivedList[i].innerText,
                                supplier: supplierList[i].innerText,
                                status: statusList[i].innerText,
                                id: rowIds[i].value,
                                pid: pIds[i].value
                            });
                        } 

                       // Store in HTML
                        var poListHtml = `
                            <table id="fromTable_${batchNumber}">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Product Name</th>
                                        <th>Qty Ordered</th>
                                        <th>Qty Received</th>
                                        <th>Qty Delivered</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        poListArr.forEach((poList, index) => {
                            poListHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td class="po_product alignLeft">${poList.name}</td>
                                    <td class="po_qty_ordered">${poList.qtyOrdered}</td>
                                    <td class="po_qty_received">${poList.qtyReceived}</td>
                                    <td class="po_qty_delivered">
                                        <input type="number" value="0" />
                                    </td>
                                    <td class="po_qty_supplier alignLeft">${poList.supplier}</td>
                                    <td>
                                        <select class="po_qty_status">
                                            <option value="pending" ${poList.status === 'pending' ? 'selected' : ''}>pending</option>
                                            <option value="incomplete" ${poList.status === 'incomplete' ? 'selected' : ''}>incomplete</option>
                                            <option value="complete" ${poList.status === 'complete' ? 'selected' : ''}>complete</option>
                                        </select>
                                        <input type="hidden" class="po_qty_row_id" value="${poList.id}">
                                        <input type="hidden" class="po_qty_pid" value="${poList.pid}">
                                    </td>
                                </tr>
                            `;
                        });

                        poListHtml += `
                                </tbody>
                            </table>
                        `; 

                        // Remove unintended newlines or whitespace
                        poListHtml = poListHtml.replace(/\n|\r/g, ''); 

                        // Pass the sanitized HTML to BootstrapDialog
                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_PRIMARY,
                            title: 'Update Purchase Order: Batch: <strong>' + batchNumber + '</strong>',
                            message: poListHtml,
                            callback: function (toAdd) {
                                console.log(toAdd);
                                //If we add 
                                if (toAdd) { 

                                    formTableContainer = 'fromTable_'+ batchNumber;   
 
                                    qtyReceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received '); 
                                    qtyDeliveredList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_delivered input'); 
                                    qtyOrderedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered '); 
                                    statusList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_status');
                                    rowIds = document.querySelectorAll('#' + formTableContainer + ' .po_qty_row_id');
                                    pids = document.querySelectorAll('#' + formTableContainer + ' .po_qty_pid');


                                    poListArrForm =[] ;
                                    for(i=0; i<qtyDeliveredList.length; i++) {
                                        poListArrForm.push({ 
                                            qtyReceive : qtyReceivedList[i].innerText,  
                                            qtyDelivered: qtyDeliveredList[i].value,
                                            qtyOrdered: qtyOrderedList[i].innerText, 
                                            status: statusList[i].value,
                                            id:rowIds[i].value,
                                            pid: pids[i].value  // Product ID for updating stock record
                                        });
                                    } 

                                    //send request /Update database
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            payload: poListArrForm 
                                        } ,
                                        url: 'database/update-order.php',
                                        dataType: 'json',
                                        success: function (data) {
                                            message = data.message;

                                            BootstrapDialog.alert({
                                                type: data.success
                                                    ? BootstrapDialog.TYPE_SUCCESS
                                                    : BootstrapDialog.TYPE_DANGER,
                                                message: message,
                                                callback: function () {
                                                    if (data.success) window.location.reload();
                                                }
                                            });
                                        }
                                    });
                                }
                            }
                        });

                    } 
                });
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