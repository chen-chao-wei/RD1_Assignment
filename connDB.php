<?php 
    
    try {
        $conn = new PDO('mysql:host=localhost:8889;dbname=weather;charset=utf8', 'root', 'root');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
?>