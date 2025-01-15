<?php

$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];

// Whitelist valid tables to prevent SQL injection
$allowedTables = ['users', 'suppliers', 'products', 'productsuppliers'];

if (!in_array($table, $allowedTables)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid table specified.'
    ]);
    exit();
}

try {
    include('connection.php');

    // Delete from junction table if applicable
    if ($table === 'suppliers') {
        $command = $conn->prepare("DELETE FROM productsuppliers WHERE supplier = :id");
        $command->execute([':id' => $id]);
    }
    if ($table === 'products') {
        $command = $conn->prepare("DELETE FROM productsuppliers WHERE products = :id");
        $command->execute([':id' => $id]);
    }

    // Delete from the main table
    $command = $conn->prepare("DELETE FROM $table WHERE id = :id");
    $command->execute([':id' => $id]);

    echo json_encode([
        'success' => true,
        'message' => 'Record deleted successfully.'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting record' . $e->getMessage()
    ]);
}
?>
