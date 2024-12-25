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
                                <div class="alignRight">
                                    <button class="orderBtn orderProductBtn" id="orderProductBtn">Add More
                                        Product</button>
                                </div>
                                <div class="quantityContainer">
                                    <div id="orderProductList"> 
    
                                    </div>
                                    <div class="alignRight marginTop">
                                        <button class="orderBtn submitOrderProductBtn ">Submit Order</button>
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
        var products = <?= $products ?>;
        var counter = 0;

        function script() {
            var vm = this;

            let productOptions = '\
                            <div>\
                                <label for="product_name" >PRODUCT NAME</label>\
                                  <select name="product_name" id="product_name" class="productNameSelect">\
                                   <option value="">Select Product</option>\
                                   INSERTPRODUCTHERE\
                                  </select>\
                                  <button class="appbtn removeOrderBtn">Remove</button>\
                            </div >'; 


            this.initialize = function () {
                this.registerEvents();
                this.randerProductOptions();
            },

                this.randerProductOptions = function () { 
                    let optionHtml = '';
                    products.forEach((product) => {
                        optionHtml += '<option value="' + product.id + '">' + product.product_name + '</option>';
                    });

                    productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
                },

                this.registerEvents = function () {

                    document.addEventListener('click', function (e) {
                        let targetElement = e.target;
                        let classList = targetElement.classList;

                        // Add new product order event
                        if (targetElement.id === 'orderProductBtn') {
                            let orderProductListContainer = document.getElementById('orderProductList');

                            orderProductListContainer.innerHTML += '\
                                <div class="orderProductRow">\
                                    '+ productOptions +'\
                                    <div class="suppliersRow" id="suppliersRow_'+ counter +'" data-counter="'+ counter +'"></div>\
                                </div>\
                            ';
                            counter++;  
                        }

                        // Remove product order event
                        if (targetElement.classList.contains('removeOrderBtn')) { 
                            let orderRow = targetElement
                            .closest('div.orderProductRow');

                            // Remove element
                            orderRow.remove(); 
                        }
                    });
                    
                    document.addEventListener('change', function (e){
                        let targetElement = e.target;
                        let classList = targetElement.classList;
                        
                        if(classList.contains('productNameSelect')){
    
                            let pid  = targetElement.value; 

                            let counterId = targetElement
                            .closest('div.orderProductRow')
                            .querySelector('.suppliersRow')
                            .dataset.counter; 
                             
                            $.get('database/get-product-supplier.php', {id: pid}, function(suppliers){
                                vm.renderSupplierRows(suppliers, counterId);
                            }, 'json')
                            
                        } 
                    });
                },

                this.renderSupplierRows = function(suppliers, counterId){

                    let supplierRows = '';

                    suppliers.forEach((supplier) => { 
                        supplierRows  += '\
                            <div class="row">\
                                <div style="width: 50%;">\
                                    <p class="supplierName">'+ supplier.supplier_name +'</p>\
                                </div>\
                                <div style="width: 50%;">\
                                    <label for="quantity">Quantity:</label>\
                                    <input type="number" id="quantity" class="orderProductQty" placeholder="Enter quantity..."\
                                        name="quantity" />\
                                </div>\
                            </div>';   

                    });

                    //Append to container 

                    let supplierRowsCounter = document.getElementById('suppliersRow_' + counterId);
                    supplierRowsCounter.innerHTML = supplierRows;
                }


        }

        (new script()).initialize();
    </script>
</body>

</html>