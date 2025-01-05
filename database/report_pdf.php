<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
function __construct(){ 
    parent::__construct('L');
}

    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width, and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Header
        $w = array(15, 65, 40, 20, 40, 48, 48);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Color and font restoration
        $this->SetTextColor(0);
        $this->SetFont('');
         
    
        foreach ($data as $row) {
            $this->Cell($w[0], 30, $row[0], 'LRBT', 0, 'C');
            
            // Render the image with proper alignment
            if (!empty($row[1]) && file_exists('.././uploads/products/' . $row[1])) {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Image('.././uploads/products/' . $row[1], $x + 17, $y + 5, 30, 20); // Adjusted width and height
                $this->Cell($w[1], 30, '', 'LRBT', 0, 'C'); // Empty cell for image
            } else {
                $this->Cell($w[1], 30, 'No Image', 'LRBT', 0, 'C');
            }
    
            $this->Cell($w[2], 30, $row[2], 'LRBT', 0, 'C');
            $this->Cell($w[3], 30, $row[3], 'LRBT', 0, 'C');
            $this->Cell($w[4], 30, $row[4], 'LRBT', 0, 'C');
            $this->Cell($w[5], 30, $row[5], 'LRBT', 0, 'C');
            $this->Cell($w[6], 30, $row[6], 'LRBT', 0, 'C');
            
            $this->Ln();
        }
        
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    
}

$type = $_GET['report'];
$report_headers =[
    'product' => 'Product Report'
];

include('connection.php');

if ($type == 'product') {
    // Column headings - replace from mysql database
    $header = array('id', 'image', 'product_name', 'stock', 'created_by', 'created_at', 'updated_at');

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
            $product['pid'],
            $product['img'],
            $product['product_name'],
            // $product['description'],
            number_format($product['stock']),
            $product['created_by'],
            date('M d, Y h:i:s A', strtotime($product['created_at'])),
            date('M d, Y h:i:s A', strtotime($product['updated_at']))
        ];
    } 
}

//Start pdf
$pdf = new PDF();
$pdf->SetFont('Arial', '', 20);
$pdf->AddPage();

$pdf->Cell(80);
$pdf->Cell(110,10,$report_headers[$type],0,0,'C');
$pdf->SetFont('Arial', '', 10);

$pdf->Ln();
$pdf->Ln();

$pdf->FancyTable($header, $data);
$pdf->Output();
?>