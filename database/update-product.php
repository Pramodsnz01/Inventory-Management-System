<?php
header('Content-Type: application/json');

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$pid = $_POST['pid'];

// Upload the image
$target_dir = "../uploads/products/";


$file_name_value = null;
$file_data = $_FILES['img'];

if ($file_data['tmp_name'] !== '') {
    $file_name = $file_data['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = 'product-' . time() . '.' . $file_ext;

    $check = getimagesize($file_data['tmp_name']);
    if ($check) {
        if (move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
            $file_name_value = $file_name;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to upload the image.'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Uploaded file is not a valid image.'
        ]);
        exit;
    }
}


// Update the product records.
try {
    include('connection.php');
    
    $sql = "UPDATE products SET product_name = ?, description = ?, img = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$product_name, $description, $file_name_value, $pid]);
    
    // Delete existing supplier associations.
    $sql = "DELETE FROM productsuppliers WHERE product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pid]);
    
    //loop through the suppliers and add the record 
    //Get suppliers. 
    $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
    foreach ($suppliers as $supplier) {
        $supplier_data = [
            'supplier_id' => $supplier,
            'product_id' => $pid,
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
        'message' => '<strong>' . htmlspecialchars($product_name) . '</strong> updated successfully to the system.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing your request: ' . $e->getMessage()
    ]);
}
