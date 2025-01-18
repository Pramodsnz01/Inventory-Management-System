<?php
session_start();

// Validate if products and quantity are present in the request
if (!isset($_POST['products']) || !isset($_POST['quantity']) || empty($_POST['products'])) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Please select at least one product and specify a valid quantity.'
    ];
    header('location: ../product-order.php');
    exit();
}

$post_data = $_POST;
$products = $post_data['products'];
$qty = array_values($post_data['quantity']);

$post_data_arr = [];

// Map product IDs with quantities
foreach ($products as $key => $pid) {
    if (isset($qty[$key])) {
        $post_data_arr[$pid] = $qty[$key];
    }
}

// Include database connection
include('connection.php');

// Store data
$batch = time();

$success = false;

try {
    foreach ($post_data_arr as $pid => $supplier_qty) {
        foreach ($supplier_qty as $sId => $qty) {
            // Validation for quantity
            if (!is_numeric($qty) || $qty <= 0) {
                // Invalid quantity
                $_SESSION['response'] = [
                    'success' => false,
                    'message' => 'Invalid quantity provided. Quantity must be a valid number.'
                ];
                header('location: ../product-order.php');
                exit();
            }

            // Insert into database
            $values = [
                'supplier' => $sId,
                'product' => $pid,
                'quantity_ordered' => $qty,
                'status' => 'pending',
                'batch' => $batch,
                'created_by' => $_SESSION['user']['id'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $sql = "INSERT INTO order_product (supplier, product, quantity_ordered, status, batch, created_by, created_at, updated_at) 
            VALUES 
            (:supplier, :product, :quantity_ordered, :status, :batch, :created_by, :created_at, :updated_at)";

            $stmt = $conn->prepare($sql);
            $stmt->execute($values); // Executes the SQL query.
        }
    }

    $success = true;
    $message = 'Order successfully created!';
} catch (\Throwable $th) {
    $message = $th->getMessage();
}

// Store the response in session
$_SESSION['response'] = [
    'success' => $success,
    'message' => $message
];

// Redirect to product order page
header('location: ../product-order.php');
exit();
?>
