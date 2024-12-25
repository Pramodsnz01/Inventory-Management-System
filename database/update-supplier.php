<?php
header('Content-Type: application/json');

$supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
$supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$supplier_id = $_POST['sid'];

// Update the product records.
try {
    include('connection.php');
    
    $sql = "UPDATE suppliers SET supplier_name = ?, supplier_location = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$supplier_name, $supplier_location, $email, $supplier_id]);
    
    // Delete existing supplier associations.
    $sql = "DELETE FROM productsuppliers WHERE supplier = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$supplier_id]);
    
    //loop through the products and add the record 
    //Get products. 
    $products = isset($_POST['products']) ? $_POST['products'] : '';
    foreach ($products as $product) {
        $supplier_data = [
            'supplier_id' => $supplier_id,
            'product_id' => $product,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $sql = "INSERT INTO 
            productsuppliers (supplier, product, created_at, updated_at) 
            VALUES 
            (:supplier_id, :product_id, :created_at, :updated_at)";

        $stmt = $conn->prepare($sql);
        $stmt->execute($supplier_data); // Executes the SQL query.

    }


    echo json_encode([
        'success' => true,
        'message' => '<strong>' . htmlspecialchars($supplier_name) . '</strong> updated successfully to the system.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing your request: ' . $e->getMessage()
    ]);
}
