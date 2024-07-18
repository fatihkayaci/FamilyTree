<?php
session_start();
include ("../dbConnection.php");

try {
    $personID = $_POST['personID'];
    $parentNo = $_POST['parentNo'];
    $wifeNo = $_POST['wifeNo'];
   
    $sql = "INSERT INTO tbl_relationship (personID, parentNo, wifeNo)
    VALUES (:personID, :parentNo, :wifeNo)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':personID', $personID);
    $stmt->bindParam(':parentNo', $parentNo);
    $stmt->bindParam(':wifeNo', $wifeNo);
    $stmt->execute();
  
    $sql2 = "UPDATE tbl_personal SET parentNo = :parentNo
            WHERE personID = :personID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':personID', $personID);
    $stmt->bindParam(':parentNo', $parentNo);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>
 