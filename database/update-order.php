<?php
$purchase_orders = $_POST['payload'];

include('connection.php');

try {
    foreach ($purchase_orders as $po) {
        $delivered = (int) $po['qtyDelivered'];

        // Skip if no delivered quantity
        if ($delivered > 0) {
            $cur_qty_received = (int) $po['qtyReceive'];
            $ordered = (int) $po['qtyOrdered'];
            $status = $po['status'];
            $row_id = $po['id'];
            $product_id = (int) $po['pid'];

            // Calculate updated received quantity
            $updated_qty_received = $cur_qty_received + $delivered;
            $qty_remaining = $ordered - $updated_qty_received;

            // Update the order_product table
            $sql = "UPDATE order_product SET quantity_received = ?, status = ?, quantity_remaining = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$updated_qty_received, $status, $qty_remaining, $row_id]);
 

            // Insert into the order_product_history table
            $delivery_history = [
                'order_product_id' => $row_id,
                'qty_received' => $delivered,
                'date_received' => date("Y-m-d H:i:s"),
                'date_updated' => date("Y-m-d H:i:s")
            ];

            $sql = "INSERT INTO 
                order_product_history (order_product_id, qty_received, date_received, date_updated) 
                VALUES 
                (:order_product_id, :qty_received, :date_received, :date_updated)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($delivery_history);

            // script for updating the main product quantity
            // select stmt to pull the cur quantity from the product
            
            $stmt = $conn->prepare("SELECT products.stock FROM products WHERE id = $product_id"); 
            
            $stmt->execute();
            $product = $stmt->fetch();
            
            $cur_stock = (int) $product['stock'];
            
            // update stmt to add the delivery product to the cur quantity
            $updated_stock = $cur_stock + $delivered; 
            $sql = "UPDATE products SET stock = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$updated_stock, $product_id]); 
        }
    }
    $response = [
        'success' => true,
        'message' => 'Purchase order successfully updated!'
    ];
} catch (\Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Error processing your request: ' . $e->getMessage()
    ];
}

echo json_encode($response);
