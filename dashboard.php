<?php
// Start session
session_start();
 
// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data from session
$user = $_SESSION['user'];

//Get graph data - purchase order by status
include('database/po_status_pie_graph.php');

//Get graph data - supplier product count
include('database/supplier_product_bar_graph.php');

//Get line graph data - delivery history per day
include('database/delivery_history_graph.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard- Inventory Management System</title>
    <link rel="stylesheet" href="css/dashboard.css"> 
    <script src="https://kit.fontawesome.com/4d31e6f82d.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="dashboardmainContainer">
        <!-- sidebar -->
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <!-- topnav -->
            <?php include('partials/app-topnav.php') ?>
            <?php if(in_array('dashboard_view', $user['permissions'])) { ?>
            <div class="dashboard_content">
                <div class="dashboardContent_main">
                    <!-- Dashboard content goes here -->
                    <div class="scroolable">
                        <div class="line">
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                                <p class="highcharts-description">
                                    Here is the breakdown of purchase orders by status.
                                </p>
                            </figure>
                        </div>
                        <div class=" line">
                            <figure class="highcharts-figure">
                                <div id="containerBarChart"></div>
                                <p class="highcharts-description">
                                    Here is the breakdown of products count assigned to supplier.
                                </p>
                            </figure>
                        </div>
                        <div class=" line"> 
                            <div id="deliveryHistory"></div>
                            <p class="highcharts-description">
                                Basic line chart showing trends in a dataset. This chart includes the
                                product delivered per day.
                            </p>
                        </div>
                    </div> 
                </div>
            </div>
            <?php } else { ?>
                <div id="errorMessage">You do not have permission to view this page.</p></div>
            <?php }?>
        </div>
    </div>
    <script src="js/script.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var graphData = <?= json_encode($results) ?>;
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Purchase order by status'
            },
            tooltip: {
                // valueSuffix: '%'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.y}',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [
                {
                    name: 'Status',
                    colorByPoint: true,
                    data: graphData
                }
            ]
        });

        var bar_graphData = <?= json_encode($bar_count) ?>;
        var bar_graphCategoties = <?= json_encode($categories) ?>;

        Highcharts.chart('containerBarChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Product Count Assigned To Supplier'
            },
            xAxis: {
                categories: bar_graphCategoties,
                crosshair: true,
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Product Count'
                }
            },
            tooltip: {
                // valueSuffix: ' (1000 MT)'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Suppliers',
                    data: bar_graphData
                }
            ]
        });

        var lineCategories = <?= json_encode($line_categories) ?>;
        var lineData = <?= json_encode($line_data) ?>;
        Highcharts.chart('deliveryHistory', {

            chart: {
                type: 'spline',
            },

            title: {
                text: 'Delivery History',
                align: 'center',
            },

            yAxis: {
                title: {
                    text: 'Product Delivered Per Day'
                }
            },

            xAxis: {
                categories: lineCategories
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    }
                }
            },

            series: [{
                name: 'Product Delivered',
                data: lineData
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });


    </script>
</body>

</html>