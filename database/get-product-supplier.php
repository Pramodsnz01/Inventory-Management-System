<?php

include('connection.php');

// Get the product ID
$id = $_GET['id'] ?? null;

// Validate product ID
if (!$id || !is_numeric($id)) {
    echo json_encode(['error' => 'Invalid product ID.']);
    exit;
}

try {
    // Fetch suppliers with a parameterized query
    $stmt = $conn->prepare("
        SELECT supplier_name, suppliers.id
        FROM suppliers
        JOIN productsuppliers
        ON productsuppliers.supplier = suppliers.id
        WHERE productsuppliers.product = :productId
    ");
    $stmt->bindParam(':productId', $id, PDO::PARAM_INT);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode($suppliers ?: ['error' => 'No suppliers found for this product.']);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching suppliers.']);
}
?>
