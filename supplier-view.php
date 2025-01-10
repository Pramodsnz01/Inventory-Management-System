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
    <title>View Suppliers- Inventory Management System</title>
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
                <?php if (in_array('supplier_view', $user['permissions'])) { ?>

                    <div class="dashboardContent_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-list"></i> Our Suppliers</h1>
                                <div class="section_content">
                                    <div class="users">

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Location</th>
                                                    <th>Contact Details</th>
                                                    <th>Products</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($suppliers as $index => $supplier) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= $supplier['supplier_name'] ?></td>
                                                        <td><?= $supplier['supplier_location'] ?></td>
                                                        <td><?= $supplier['email'] ?></td>
                                                        <td>
                                                            <?php
                                                            $product_list = '-';

                                                            $sId = $supplier['id'];
                                                            $stmt = $conn->prepare("SELECT product_name FROM products, productsuppliers WHERE productsuppliers.supplier = $sId AND productsuppliers.product = products.id");

                                                            $stmt->execute();
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if ($row) {
                                                                $product_arr = array_column($row, 'product_name');
                                                                $product_list = '<li>' . implode("</li><li>", $product_arr);

                                                            }
                                                            echo $product_list;

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $uId = $supplier['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id= $uId");

                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                            echo $created_by_name;
                                                            ?>
                                                        </td>
                                                        <td><?= date('M d,Y @ h:i:s: A', strtotime($supplier['created_at'])) ?>
                                                        </td>
                                                        <td><?= date('M d,Y @ h:i:s: A', strtotime($supplier['updated_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href=""
                                                                class="in_array('supplier_edit', $user['permissions']) ? 'updateSupplier' : 'accessDeniedEr' ?>"
                                                                data-sid="<?= $supplier['id'] ?>"><i class="fa fa-pencil"></i>
                                                                Edit</a>
                                                            <a href=""
                                                                class="in_array('supplier_delete', $user['permissions']) ? 'deleteSupplier' : 'accessDeniedEr' ?>"
                                                                data-name="<?= $supplier['supplier_name'] ?>"
                                                                data-sid="<?= $supplier['id'] ?>"><i class="fa fa-trash"></i>
                                                                Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="userCount"><?= count($suppliers) ?> Suppliers</p>
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
    <?php
    include('partials/app-scripts.php');

    $show_table = 'products';
    $products = include('database/show.php');

    $products_arr = [];
    foreach ($products as $product) {
        $products_arr[$product['id']] = $product['product_name'];
    }
    $products_arr = json_encode($products_arr);
    ?>


    <script>

        var productsList = <?= $products_arr ?>;

        function script() {
            var vm = this;

            this.registerEvents = function () {
                document.addEventListener('click', function (e) {
                    let targetElement = e.target;
                    let classList = targetElement.classList;

                    if (classList.contains('deleteSupplier')) {
                        e.preventDefault();

                        let sId = targetElement.dataset.sid;
                        let supplierName = targetElement.dataset.name;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Supplier',
                            message: 'Are you sure to delete <strong>' + supplierName + '</strong>?',
                            callback: function (isDelete) {
                                if (isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: sId, table: 'suppliers' },
                                        url: 'database/delete.php',
                                        dataType: 'json',
                                        success: function (data) {
                                            BootstrapDialog.alert({
                                                type: data.success
                                                    ? BootstrapDialog.TYPE_SUCCESS
                                                    : BootstrapDialog.TYPE_DANGER,
                                                message: data.message || '<strong>' + supplierName + '</strong>' + ' successfully deleted!',
                                                callback: function () {
                                                    if (data.success) window.location.reload();
                                                }
                                            });
                                        },
                                        error: function () {
                                            BootstrapDialog.alert({
                                                type: BootstrapDialog.TYPE_DANGER,
                                                message: 'Failed to delete the product. Please try again.'
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }

                    if (classList.contains('accessDeniedEr')) {
                        e.preventDefault();
                        BootstrapDialog.alert({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'ACCESS DENIED!.'
                        });
                    }

                    if (classList.contains('updateSupplier')) {
                        e.preventDefault();

                        let sId = targetElement.dataset.sid;
                        vm.showEditDialog(sId);
                    }
                });
                document.addEventListener('submit', function (e) {
                    e.preventDefault();
                    targetElement = e.target;

                    if (targetElement.id === 'editSupplierForm') {
                        vm.saveUpdatedData(targetElement);
                    }

                })
            };

            this.saveUpdatedData = function (form) {
                $.ajax({
                    method: 'POST',
                    data: {
                        supplier_name: document.getElementById('supplier_name').value,
                        supplier_location: document.getElementById('supplier_location').value,
                        email: document.getElementById('email').value,
                        products: $('#products').val(),
                        sid: document.getElementById('sid').value
                    },
                    url: 'database/update-supplier.php',
                    dataType: 'json',
                    success: function (data) {
                        BootstrapDialog.alert({
                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                            callback: function () {
                                if (data.success) window.location.reload();
                            }
                        });
                    },
                    error: function () {
                        BootstrapDialog.alert({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Failed to update the product. Please try again.'
                        });
                    }
                });
            };

            this.showEditDialog = function (id) {
                $.get('database/get-supplier.php', { id: id }, function (supplierDetails) {
                    let curPoducts = supplierDetails['products'];
                    let productOptions = '';
                    for (const [pId, pName] of Object.entries(productsList)) {
                        selected = curPoducts.indexOf(pId) > -1 ? 'selected' : '';
                        productOptions += "<option " + selected + " value='" + pId + "'>" + pName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Update <strong>' + supplierDetails.supplier_name + '</strong>',
                        message: '<form id="editSupplierForm">\
                        <div class="appFormInputContainer">\
                            <label for= "supplier_name" > Supplier Name</label>\
                            <input type="text" id="supplier_name" value="'+ supplierDetails.supplier_name + '" placeholder="Enter the supplier name..."              class="appFormInput" name="supplier_name" />\
                        </div >\
                        <div class="appFormInputContainer">\
                            <label for="supplier_location">Location</label>\
                            <input type="text" id="supplier_location" value="'+ supplierDetails.supplier_location + '" placeholder="Give product supplier location..." class="appFormInput" name="supplier_location"></input> \
                        </div> \
                        <div class="appFormInputContainer">\
                            <label for="email">Email</label>\
                            <input type="text" id="email" value="'+ supplierDetails.email + '" placeholder="Give product supplier email..." class="appFormInput" name="email"></input> \
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="products">Products</label>\
                            <select name="products[]" id="products" multiple>\
                                <option value="">Select Products</option>\
                                            ' + productOptions + '\
                            </select>\
                        </div>\
                        <input type="hidden" name="sid" id="sid" value="' + supplierDetails.id + '" />\
                        <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden" />\
                    </form > ',
                        callback: function (isUpdate) {
                            if (isUpdate) {
                                document.getElementById('editSupplierSubmitBtn').click();
                            }
                        }
                    });
                }, 'json');
            };


            this.initialize = function () {
                this.registerEvents();
            };
        }

        var script = new script();
        script.initialize();
    </script>


</body>

</html>