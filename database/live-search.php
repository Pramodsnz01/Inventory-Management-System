<?php
include('connection.php');

$search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';
$search_term = trim(strtolower($search_term));

$tables = [
    'users' => ' ',
    'products' => 'product_name',
    'suppliers' => 'supplier_name'
];

$results = [];
$length = 0;

foreach ($tables as $table_name => $col) {
    if ($table_name === 'users') {
        $stmt = $conn->prepare("SELECT * FROM $table_name WHERE first_name LIKE :search_term OR last_name LIKE :search_term ORDER BY created_at DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM $table_name WHERE $col LIKE :search_term ORDER BY created_at DESC");
    }
    
    $stmt->execute(['search_term' => '%' . $search_term . '%']);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $rows = $stmt->fetchAll();
    $length += count($rows);
    $results[$table_name] = $rows; // Store the rows under the table name key
}

echo json_encode([
    'length' => $length,
    'data' => $results // Send all results as an object with keys for each table
]);
?>
