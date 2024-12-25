<?php 

    $data = $_POST;
    $user_id = (int) $data['user_id'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    $email = $data['email'];

    try {
        $sql = "UPDATE users SET  email= ? , last_name=?, first_name=?, updated_at=? WHERE id = ?";
    
        include('connection.php');
    
        $conn-> prepare ($sql)->execute([$email, $first_name, $last_name , date('Y-m-d h:i:s') , $user_id]); // Executes the SQL query.

        echo json_encode([
            'success' => true,
            'message' => $first_name. ' ' . $last_name. ' '.'successfully updated.'
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your update request!'
        ]);
    }

?>