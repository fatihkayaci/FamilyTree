<?php
include ("../dbConnection.php");
try{
        
    // Formdan gelen verileri al
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $deathDate = $_POST['deathDate'];
    $parentID = $_POST['parentID'];
    echo $firstName;
    $sql = "INSERT INTO tbl_personal (firstName, lastName, birthDate, deathDate, parentID)
        VALUES (:firstName, :lastName, :birthDate, :deathDate, :parentID)";

    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':deathDate', $deathDate);
    $stmt->bindParam(':parentID', $parentID);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>