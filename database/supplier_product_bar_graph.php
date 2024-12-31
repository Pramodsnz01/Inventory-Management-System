<?php
include('connection.php');

//Query suppliers
$stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
$stmt->execute();
$rows = $stmt->fetchAll();

$categories = [];
$bar_count = [];

$colors = ['#ff0000', '#0000ff', '#add8e6', '#800080', '#00ff00', '#ff00ff', '#800000'];
$counter = 0;
//Query supplier product count
foreach ($rows as $key =>  $row){
    $id = $row['id'];

    $categories[] = $row['supplier_name']; 

    //Query count.
    $stmt = $conn->prepare("SELECT COUNT(*) as p_count FROM productsuppliers WHERE productsuppliers.supplier= '" . $id . "'");
    $stmt->execute();
    $row = $stmt->fetch();

    $count = $row['p_count'];

    if(!isset($colors[$key])) $counter= 0;

    $bar_count[] = [
        'y' => (int) $count,
        'color' => $colors[$counter]  //Assign a color for each supplier.
    ];
    $counter++;
} 

?>