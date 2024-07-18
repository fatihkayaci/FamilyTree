<?php
session_start();
include ("../dbConnection.php");

try {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $birthDate = $_POST['birthDate']; // Kullanıcıdan gelen tarih: "15 Temmuz 2024"
    $deathDate = $_POST['deathDate'];

    $sql = "INSERT INTO tbl_personal (firstName, lastName, gender, birthDate, deathDate)
    VALUES (:firstName, :lastName, :gender, :birthDate, :deathDate)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':deathDate', $deathDate);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>
 