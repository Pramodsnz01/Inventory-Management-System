<?php
include('connection.php');

$statuses = ['pending', 'complete', 'incomplete'];

$results = [];

//Loop through the status and Query
foreach ($statuses as $status){
    $stmt = $conn->prepare("SELECT COUNT(*) as status_count FROM order_product WHERE status= '" . $status. "'");
    $stmt->execute();
    $row = $stmt->fetch();

    $count = $row['status_count'];
 

    $results[] = [
        'name'=> strtoupper($status),
        'y'=> (int) $count
    ];
}

?>