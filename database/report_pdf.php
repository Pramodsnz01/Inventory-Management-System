<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function __construct()
    {
        parent::__construct('L');
    }

    // Colored table
    function FancyTable($header, $data, $row_height = 30)
    {
        // Colors, line width, and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
 

        // Header
        $width_sum = 0;
        foreach ($header as $header_key => $header_data) {
            $this->Cell($header_data['width'], 7, $header_key, 1, 0, 'C', true);
            $width_sum += $header_data['width'];
        }

        $this->Ln();

        // Color and font restoration
        $this->SetTextColor(0);
        $this->SetFont('');

        $header_keys = array_keys($header);
        foreach ($data as $row) {
            // Check for page break dynamically based on `$row_height`
            if ($this->GetY() + $row_height > $this->PageBreakTrigger) {
                $this->AddPage();
                // Redraw header on new page
                // foreach ($header as $header_key => $header_data) {
                //     $this->Cell($header_data['width'], 7, $header_key, 1, 0, 'C', true); 
                // }
                $this->Ln();
            }

            foreach ($header_keys as $header_key) {
                $content = $row[$header_key]['content'];
                $width = $header[$header_key]['width'];
                $align = $row[$header_key]['align'];

                // Handle images dynamically
                if ($header_key == 'image') {
                    if (!empty($content) && file_exists('.././uploads/products/' . $content)) {
                        // Save current X and Y
                        $x = $this->GetX();
                        $y = $this->GetY();

                        // Adjust image position dynamically based on `$row_height`
                        $this->Image('.././uploads/products/' . $content, $x + 5, $y + 5, $width - 10, $row_height - 10);

                        // Leave space for the image
                        $this->Cell($width, $row_height, '', 'LRBT', 0, 'C');
                    } else {
                        $this->Cell($width, $row_height, 'No Image', 'LRBT', 0, 'C');
                    }
                } else {
                    $this->Cell($width, $row_height, $content, 'LRBT', 0, $align);
                }
            }
            $this->Ln();
        }

        // Closing line
        $this->Cell($width_sum, 0, '', 'T');
    } 

}

$type = $_GET['report'];
$report_headers = [
    'product' => 'Product Report',
    'supplier' => 'Supplier Report',
    'purchase_orders' => 'Purchase Order Report',
    'delivery' => 'Delivery Report'
];

$row_height = 30;

include('connection.php');

//Product Export
if ($type == 'product') {
    // Column headings - replace from mysql database
    $header = [
        'id' => ['width' => 15],
        'image' => ['width' => 40],
        'product_name' => ['width' => 40],
        'stock' => ['width' => 20],
        'created_by' => ['width' => 45],
        'created_at' => ['width' => 57],
        'updated_at' => ['width' => 57]
    ];

    // Load Product
    $stmt = $conn->prepare("SELECT *, products.id as pid FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $products = $stmt->fetchAll();

    $data = [];
    foreach ($products as $product) {
        $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
        unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

        // Detect double quotes and escape any value that contains them
        array_walk($product, function (&$str) {
            // Replace tab characters with an escaped version
            $str = preg_replace("/\t/", "\\t", $str);

            // Replace newline characters (CR or CRLF) with an escaped version
            $str = preg_replace("/\r?\n/", "\\n", $str);

            // If the string contains a double quote, escape it and wrap the string in double quotes
            if (strstr($str, '"')) {
                $str = '"' . str_replace('"', '""', $str) . '"';
            }
        });

        $data[] = [
            'id' => [
                'content' => $product['pid'],
                'align' => 'C'
            ],
            'image' => [
                'content' => $product['img'],
                'align' => 'C'
            ],
            'product_name' => [
                'content' => $product['product_name'],
                'align' => 'C'
            ],
            'stock' => [
                'content' => number_format($product['stock']),
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $product['created_by'],
                'align' => 'C'
            ],
            'created_at' => [
                'content' => date('M d, Y h:i:s A', strtotime($product['created_at'])),
                'align' => 'C'
            ],
            'updated_at' => [
                'content' => date('M d, Y h:i:s A', strtotime($product['updated_at'])),
                'align' => 'C'
            ]
        ];
    }
}

//Supplier Export
if ($type === 'supplier') {
    $stmt = $conn->prepare("SELECT suppliers.id as sid, suppliers.created_at as 'created at', users.first_name, users.last_name, suppliers.supplier_location, suppliers.email, suppliers.created_by FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC");

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $suppliers = $stmt->fetchAll();

    $header = [
        'supplier_id' => ['width' => 35],
        'supplier_location' => ['width' => 60],
        'email' => ['width' => 60],
        'created_by' => ['width' => 60],
        'created_at' => ['width' => 60]
    ];

    //Headers
    $is_header = true;
    foreach ($suppliers as $supplier) {
        $supplier['created_by'] = $supplier['first_name'] . ' ' . $supplier['last_name'];

        $data[] = [
            'supplier_id' => [
                'content' => $supplier['sid'],
                'align' => 'C'
            ],
            'supplier_location' => [
                'content' => $supplier['supplier_location'],
                'align' => 'C'
            ],
            'email' => [
                'content' => $supplier['email'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $supplier['created_by'],
                'align' => 'C'
            ],
            'created_at' => [
                'content' => date('M d, Y h:i:s A', strtotime($supplier['created at'])),
                'align' => 'C'
            ]
        ];
    }

    $row_height = 10;
}

//Delivery Export
if ($type === 'delivery') {
    $stmt = $conn->prepare(
        "SELECT date_received, qty_received, first_name, last_name, products.product_name, supplier_name, batch
        FROM order_product_history, order_product, users, suppliers, products
        WHERE order_product_history.order_product_id = order_product.id 
        AND order_product.created_by = users.id 
        AND order_product.supplier = suppliers.id
        AND order_product.product = products.id
        ORDER BY order_product.batch DESC 
    "
    );

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $header = [
        'product_name' => ['width' => 60],
        'qty_received' => ['width' => 35],
        'supplier_name' => ['width' => 60],
        'created_by' => ['width' => 60],
        'date_received' => ['width' => 60]
    ];



    $deliveries = $stmt->fetchAll();

    foreach ($deliveries as $delivery) {
        $delivery['created_by'] = $delivery['first_name'] . ' ' . $delivery['last_name']; 
        $data[] = [
            'product_name' => [
                'content' => $delivery['product_name'],
                'align' => 'C'
            ],
            'qty_received' => [
                'content' => $delivery['qty_received'],
                'align' => 'C'
            ],
            'supplier_name' => [
                'content' => $delivery['supplier_name'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $delivery['created_by'],
                'align' => 'C'
            ],
            'date_received' => [
                'content' => date('M d, Y h:i:s A', strtotime($delivery['date_received'])),
                'align' => 'C'
            ]
        ];

    }
    $row_height = 10;

}
//Purchase Order Export
if ($type === 'purchase_orders') {
    $stmt = $conn->prepare(
        "SELECT products.product_name, order_product.id, order_product.quantity_ordered, order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name, order_product.created_at FROM order_product
        INNER JOIN users ON order_product.created_by = users.id 
        INNER JOIN suppliers ON order_product.supplier = suppliers.id
        INNER JOIN products ON order_product.product = products.id
        ORDER BY order_product.batch DESC 
    "
    );

    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $order_products = $stmt->fetchAll();

    $header = [
        'id' => ['width' => 10],
        'product_name' => ['width' => 40],
        'qty_ordered' => ['width' => 30],
        'qty_remaining' => ['width' => 33],
        'status' => ['width' => 24],
        'batch' => ['width' => 29],
        'supplier_name' => ['width' => 27],
        'created_by' => ['width' => 30],
        'created at' => ['width' => 55] 
    ];
 
    foreach ($order_products as $order_product) {
        $order_product['created_by'] = $order_product['first_name'] . ' ' . $order_product['last_name'];
        $data[] = [
            'id' => [
                'content' => $order_product['id'],
                'align' => 'C'
            ],
            'product_name' => [
                'content' => $order_product['product_name'],
                'align' => 'C'
            ],
            'qty_ordered' => [
                'content' => $order_product['quantity_ordered'],
                'align' => 'C'
            ],
            'qty_remaining' => [
                'content' => $order_product['quantity_remaining'],
                'align' => 'C'
            ],
            'supplier_name' => [
                'content' => $order_product['supplier_name'],
                'align' => 'C'
            ], 
            'status' => [
                'content' => $order_product['status'],
                'align' => 'C'
            ],
            'batch' => [
                'content' => $order_product['batch'],
                'align' => 'C'
            ], 
            'created_by' => [
                'content' => $order_product['created_by'],
                'align' => 'C'
            ],
            'created at' => [
                'content' => date('M d, Y h:i:s A', strtotime($order_product['created_at'])),
                'align' => 'C'
            ] 
        ];

    }
    $row_height = 10; 
}

//Start pdf
$pdf = new PDF();
$pdf->SetFont('Arial', '', 20);
$pdf->AddPage();

$pdf->Cell(80);
$pdf->Cell(110, 10, $report_headers[$type], 0, 0, 'C');
$pdf->SetFont('Arial', '', 12);

$pdf->Ln();
$pdf->Ln();

$pdf->FancyTable($header, $data, $row_height);
$pdf->Output();
?>