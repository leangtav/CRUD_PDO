<?php
$host = "localhost";
$port = 3306;
$dbname = "php_db";
$username = "root";
$password = "";
try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();

}