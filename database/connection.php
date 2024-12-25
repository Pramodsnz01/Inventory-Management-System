<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';

    //Connecting the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=inventory", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    } catch (\Throwable $th) {
        $error_message = $th->getMessage();
    }
?>