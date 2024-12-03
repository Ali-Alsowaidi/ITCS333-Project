<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "booking_rooms";

    try{
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>