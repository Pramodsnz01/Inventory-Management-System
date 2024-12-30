<?php
    $purchase_orders = $_POST['payload'];

    include('connection.php');

    try {
        foreach ($purchase_orders as $po){ 

            $received = (int) $po['qtyReceived'];
            $ordered = (int) $po['qtyOrdered'];
            $status = $po['status'];
            $row_id = $po['id'];
    
            $qty_remaining = $ordered - $received;
    
            $sql = "UPDATE order_product SET quantity_received = ?, status = ?, quantity_remaining = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$received, $status, $qty_remaining, $row_id]);
            
            $response= [
                'success' => true,
                'message' => 'Purchase order successfully updated!' 
            ];
        }
    } catch (\Exception $e) {
        $response= [
            'success' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()
        ];
    }
    echo json_encode($response);
?>