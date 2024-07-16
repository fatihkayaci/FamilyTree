<?php 
$host = "185.92.2.129";
$db_name = "familytree";
$username = "roott";
$password = "S2Ukh3jTsd_4mHug";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
} catch (PDOException $e) {
    
}
