<?php
session_start();
include('connection.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id']; // Product ID
    $table_name = $_POST['table']; // Table name

    try {
        // Step 1: Fetch the image name from the database
        $stmt = $conn->prepare("SELECT img FROM $table_name WHERE id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['img'])) {
            // Step 2: Delete the file from the directory
            $file_path = "../uploads/products/" . $product['img'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Step 3: Delete the product from the database
        $stmt = $conn->prepare("DELETE FROM $table_name WHERE id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Step 4: Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    } catch (PDOException $e) {
        // Return error response
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method!'
    ]);
}
