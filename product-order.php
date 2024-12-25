<?php
// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
//Get all products
$show_table = 'products';
$products = include('database/show.php');
$products = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Product- Inventory Management System</title>
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
                            <h1 class="section_header"><i class="fa fa-plus"></i> Order Product</h1>
                            <div>
                                <form action="database/save-order.php" method="POST">
                                    <div class="alignRight">
                                        <button type="button" class="orderBtn orderProductBtn" id="orderProductBtn">Add
                                            More
                                            Product</button>
                                    </div>
                                    <div class="quantityContainer">
                                        <div id="orderProductList">
                                            <p id="noData" style="color: #9f9f9f">No products selected.</p>
                                        </div>
                                        <div class="alignRight marginTop">
                                            <button type="submit" class="orderBtn submitOrderProductBtn ">Submit
                                                Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
    <?php include('partials/app-scripts.php'); ?>
    <script>
        var products = <?= $products ?>;
        var counter = 0;

        function script() {
            var vm = this;

            let productOptions = `
            <div>
                <label for="product_name">PRODUCT NAME</label>
                <select name="products[]" id="product_name" class="productNameSelect">
                    <option value="">Select Product</option>
                    INSERTPRODUCTHERE
                </select>
                <button class="appbtn removeOrderBtn">Remove</button>
            </div>`;

            this.initialize = function () {
                this.registerEvents();
                this.renderProductOptions();
            };

            this.renderProductOptions = function () {
                let optionHtml = '';
                products.forEach((product) => {
                    optionHtml += `<option value="${product.id}">${product.product_name}</option>`;
                });

                productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
            };

            this.registerEvents = function () {
                document.addEventListener('click', function (e) {
                    let targetElement = e.target;

                    // Add new product order event
                    if (targetElement.id === 'orderProductBtn') {
                        let noDataElement = document.getElementById('noData');
                        if (noDataElement) {
                            noDataElement.style.display = 'none'; // Hide the "No products selected" message
                        }

                        let orderProductListContainer = document.getElementById('orderProductList');

                        // Append new product order instead of clearing the container
                        orderProductListContainer.innerHTML += `
                        <div class="orderProductRow">
                            ${productOptions}
                            <div class="suppliersRow" id="suppliersRow_${counter}" data-counter="${counter}"></div>
                        </div>
                    `;
                        counter++;
                    }

                    // Remove product order event
                    if (targetElement.classList.contains('removeOrderBtn')) {
                        let orderRow = targetElement.closest('div.orderProductRow');

                        if (orderRow) {
                            orderRow.remove(); // Remove the product row

                            // Check if the orderProductList is now empty, and show "No products selected" if needed
                            let orderProductListContainer = document.getElementById('orderProductList');
                            if (orderProductListContainer.children.length === 0) {
                                let noDataElement = document.getElementById('noData');
                                if (noDataElement) {
                                    noDataElement.style.display = 'block'; // Show the "No products selected" message again
                                }
                            }
                        }
                    }
                });

                document.addEventListener('change', function (e) {
                    let targetElement = e.target;

                    if (targetElement.classList.contains('productNameSelect')) {
                        let pid = targetElement.value;

                        let counterId = targetElement
                            .closest('div.orderProductRow')
                            .querySelector('.suppliersRow')
                            .dataset.counter;

                        $.get('database/get-product-supplier.php', { id: pid }, function (suppliers) {
                                vm.renderSupplierRows(suppliers, counterId);
                            },'json'
                        );
                    }
                });
            };

            this.renderSupplierRows = function (suppliers, counterId) {
                let supplierRows = '';

                suppliers.forEach((supplier) => {
                    supplierRows += `
                    <div class="row">
                        <div style="width: 50%;">
                            <p class="supplierName">${supplier.supplier_name}</p>
                        </div>
                        <div style="width: 50%;">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" class="orderProductQty" placeholder="Enter quantity..."
                                name="quantity[${counterId}][${supplier.id}]" />
                        </div>
                    </div>`;
                });

                // Append to container
                let supplierRowsCounter = document.getElementById('suppliersRow_' + counterId);
                supplierRowsCounter.innerHTML = supplierRows;
            };
        }

        (new script()).initialize();
    </script>

</body>

</html>