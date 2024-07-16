<?php
include ("../dbConnection.php");
try{
    $personID = $_POST["personID"];

    $sql = "DELETE FROM tbl_personal WHERE personID = :personID";
    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':personID', $personID);
    $stmt->execute();
    echo "Kişi Silinmiştir.";
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}



?>