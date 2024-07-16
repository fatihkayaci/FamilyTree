<?php
include ("../dbConnection.php");
try {
    $personID = $_POST['personID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $deathDate = $_POST['deathDate'];
    echo $personID;
    echo $firstName;
    echo $lastName;
    echo $birthDate;
    echo $deathDate;

    $sql = "UPDATE tbl_personal
    SET firstName = :firstName,
        lastName = :lastName,
        birthDate = :birthDate,
        deathDate = :deathDate
    WHERE personID = :personID";


    // PDO sorgusunu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':personID', $personID);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':birthDate', $birthDate);
    $stmt->bindParam(':deathDate', $deathDate);
    $stmt->execute();
    
} catch (PDOException $e) {
    echo "hata".$e;
}
?>