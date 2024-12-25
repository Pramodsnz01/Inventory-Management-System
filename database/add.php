<?php
session_start();
//capture the table mappings.
include('table_columns.php');


//Capture the table name
$table_name = $_SESSION['table'];
$columns = $table_columns_mapping[$table_name]; 

 
//Loop through the columns
$db_arr = [];
$user = $_SESSION['user'];
foreach ($columns as $column) {
    if (in_array($column, ['created_at', 'updated_at']))
        $value = date("Y-m-d H:i:s");
    elseif ($column == 'created_by')
        $value = $user['id'];
    elseif ($column == 'password')
        $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
    elseif ($column == 'img') {
        //upload the images to our gallery
        $target_dir = "../uploads/products/";
        $file_data = $_FILES[$column];

        $value = null;
        $file_data = $_FILES['img'];

        if ($file_data['tmp_name'] !== '') {
            $file_name = $file_data['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = 'product-' . time() . '.' . $file_ext;

            $check = getimagesize($file_data['tmp_name']);
            if ($check) {
                if (move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
                    $value = $file_name;
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to upload the image.'
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Uploaded file is not a valid image.'
                ]);
                exit;
            }
        }


    } else
        $value = isset($_POST[$column]) ? $_POST[$column] : '';

    $db_arr[$column] = $value;
}

$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(", :", array_keys($db_arr));
 


//Adding record to the main table.
try {
    $sql = "INSERT INTO 
    $table_name ($table_properties) 
    VALUES 
    ($table_placeholders)";

    include('connection.php');

    $stmt = $conn->prepare($sql);
    $stmt->execute($db_arr); // Executes the SQL query.

    //Get saved id
    $product_id = $conn->lastInsertId();


    //Add Suppliers
    if($table_name === 'products'){
        $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
        if($suppliers){
            //loop through the suppliers and add the record
            foreach($suppliers as $supplier){
                $supplier_data = [
                    'supplier_id' => $supplier,
                    'product_id' => $product_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $sql = "INSERT INTO 
                productsuppliers (supplier, product, created_at, updated_at) 
                VALUES 
                (:supplier_id, :product_id, :created_at, :updated_at)"; 

                $stmt = $conn->prepare($sql);
                $stmt->execute($supplier_data); // Executes the SQL query.
            
            } 
        }
    }

    $response = [
        'success' => true,
        'message' => 'Added successfully to the system.'
    ];
} catch (PDOException $e) {
    $response = [
        'success' => true,
        'message' => $e->getMessage()
    ];
}

$_SESSION['response'] = $response;
header('location: ../' . $_SESSION['redirect_to']);
exit();
?>