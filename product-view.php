<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$show_table = 'products';
// Fetch all products from database
$products = include('database/show.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products- Inventory Management System</title>
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
                <?php if (in_array('product_view', $user['permissions'])) { ?>

                    <div class="dashboardContent_main">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="section_header"><i class="fa fa-list"></i> List Of Products</h1>
                                <div class="section_content">
                                    <div class="users">

                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Image</th>
                                                    <th>Product Name</th>
                                                    <th>Stock</th>
                                                    <th>Description</th>
                                                    <th width="10%">Suppliers</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($products as $index => $product) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td class="img">
                                                            <img class="productImages"
                                                                src="uploads/products/<?= $product['img'] ?>" alt="" />
                                                        </td>
                                                        <td class="lastName"><?= $product['product_name'] ?></td>
                                                        <td class="lastName"><?= number_format($product['stock']) ?></td>
                                                        <td class="email"><?= $product['description'] ?></td>
                                                        <td class="email">
                                                            <?php
                                                            $supplier_list = '-';

                                                            $pId = $product['id'];
                                                            $stmt = $conn->prepare("SELECT supplier_name FROM suppliers, productsuppliers WHERE productsuppliers.product = $pId AND productsuppliers.supplier = suppliers.id");

                                                            $stmt->execute();
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if ($row) {
                                                                $supplier_arr = array_column($row, 'supplier_name');
                                                                $supplier_list = '<li>' . implode("</li><li>", $supplier_arr);

                                                            }
                                                            echo $supplier_list;

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $uId = $product['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id= $uId");

                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $created_by_name = $row['first_name'] . ' ' . $row['last_name'];
                                                            echo $created_by_name;
                                                            ?>
                                                        </td>
                                                        <td><?= date('M d,Y @ h:i:s: A', strtotime($product['created_at'])) ?>
                                                        </td>
                                                        <td><?= date('M d,Y @ h:i:s: A', strtotime($product['updated_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href="" class="<?=in_array('product_edit', $user['permissions']) ? 'updateProduct' : 'accessDeniedEr' ?>" data-pid="<?= $product['id'] ?>"><i
                                                                    class="fa fa-pencil"></i> Edit</a>
                                                            <a href="" class="<?=in_array('product_delete', $user['permissions']) ? 'deleteProduct' : 'accessDeniedEr' ?>"
                                                                data-name="<?= $product['product_name'] ?>"
                                                                data-pid="<?= $product['id'] ?>"><i class="fa fa-trash"></i>
                                                                Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="userCount"><?= count($products) ?> Products</p>
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

    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

    $supplier_arr = [];
    foreach ($suppliers as $supplier) {
        $suppliers_arr[$supplier['id']] = $supplier['supplier_name'];

    }
    $supplier_arr = json_encode($suppliers_arr);
    ?>


    <script>

        var suppliersList = <?= json_encode($suppliers_arr, JSON_HEX_TAG); ?>;

        function script() {
            var vm = this;

            this.registerEvents = function () {
                document.addEventListener('click', function (e) {
                    let targetElement = e.target;
                    let classList = targetElement.classList;

                    if (classList.contains('deleteProduct')) {
                        e.preventDefault();

                        let pId = targetElement.dataset.pid;
                        let pName = targetElement.dataset.name;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Product',
                            message: 'Are you sure to delete <strong>' + pName + '</strong>?',
                            callback: function (isDelete) {
                                if (isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: pId, table: 'products' },
                                        url: 'database/delete-product.php',
                                        dataType: 'json',
                                        success: function (data) {
                                            BootstrapDialog.alert({
                                                type: data.success
                                                    ? BootstrapDialog.TYPE_SUCCESS
                                                    : BootstrapDialog.TYPE_DANGER,
                                                message: data.message || 'Operation completed.',
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

                    if(classList.contains('accessDeniedEr')){
                        e.preventDefault();
                        BootstrapDialog.alert({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'ACCESS DENIED!.'
                        });
                    }

                    if (classList.contains('updateProduct')) {
                        e.preventDefault();

                        let pId = targetElement.dataset.pid;
                        vm.showEditDialog(pId);
                    }
                });
            };

            this.saveUpdatedData = function (form) {
                $.ajax({
                    method: 'POST',
                    data: new FormData(form),
                    url: 'database/update-product.php',
                    processData: false,
                    contentType: false,
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
                $.get('database/get-product.php', { id: id }, function (productDetails) {
                    let curSuppliers = productDetails['suppliers'];
                    let supplierOption = '';
                    for (const [supId, supName] of Object.entries(suppliersList)) {
                        selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                        supplierOption += "<option " + selected + " value='" + supId + "'>" + supName + "</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Update <strong>' + productDetails.product_name + '</strong>',
                        message: '<form id="editProductForm">\
                        <div class="appFormInputContainer">\
                            <label for="product_name">Product Name</label>\
                            <input type="text" id="product_name" value="' + productDetails.product_name + '" placeholder="Enter the product name..." class="appFormInput" name="product_name" />\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="description">Description</label>\
                            <textarea id="description" placeholder="Give product short description..." class="appFormInput productTextAreaInput" name="description">' + productDetails.description + '</textarea>\
                        </div>\
                        <div class="appFormInputContainer">\
                                        <label for="description">Suppliers</label>\
                                        <select name="suppliers[]" id="suppliersSelect" multiple>\
                                            <option value="">Select Supplier</option>\
                                            ' + supplierOption + '\
                                        </select>\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="img">Product Image</label>\
                            <input type="file" name="img" />\
                        </div>\
                        <input type="hidden" name="pid" value="' + productDetails.id + '" />\
                    </form>',
                        callback: function (isUpdate) {
                            if (isUpdate) {
                                const form = document.getElementById('editProductForm');

                                const formData = new FormData(form);

                                $.ajax({
                                    method: 'POST',
                                    data: formData,
                                    url: 'database/update-product.php',
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    success: function (data) {
                                        BootstrapDialog.alert({
                                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                            message: data.message,
                                            callback: function () {
                                                if (data.success) {
                                                    window.location.reload();
                                                }
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