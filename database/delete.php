<?php

$data = $_POST;
$id = (int) $data['id'];
$table = $data['table'];


try {
    include('connection.php');

    //Delete junction table
    if ($table === 'suppliers') {
        $supplier_id = $id;
        $command = "DELETE FROM productsuppliers WHERE supplier = {$id}";
        $conn->exec($command); // Executes the SQL query.
    }
    if ($table === 'products') {
        $supplier_id = $id;
        $command = "DELETE FROM productsuppliers WHERE products = {$id}";
        $conn->exec($command); // Executes the SQL query.
    }


    //Delete main table.
    $command = "DELETE FROM $table WHERE id = {$id}";
    $conn->exec($command); // Executes the SQL query.

    echo json_encode([
        'success' => true,
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
    ]);
}

?>