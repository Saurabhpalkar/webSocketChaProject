<?php
class database{
    function connect(){
        try {
            $connect = new PDO("mysql:host=localhost;dbname=chat_app", "root", "");
            // Set PDO to throw exceptions on error
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect; 
        } catch (PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
            return null; // Return null to indicate connection failure
        }
    }
}
?>
