<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style/index.css">
</head>
<body>
<?php

session_start();
include("dbConnection.php");
try {
    $sql = "SELECT * FROM tbl_personal";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
<div id="popup">

    <form class="login-form mainpopup" id="userForm">

        <h2 class="form-signin-heading mb-3">Kişi Ekle</h2>

        <hr class="horizontal dark mt-0 w-100">

        <div class="row mt-3">
            <div class="col-md-6 col-btn">
                <input type="text" placeholder="isim" class="input" name="firstName" id="firstName" required></input>
                <br><br>
                <input type="text" placeholder="soyisim" class="input" name="lastName" id="lastName" required></input>  
                <br><br>
                <select name="gender" id="gender">
                    <option value="Erkek">Erkek</option>
                    <option value="Kadın">Kadın</option>
                </select>
                <br><br>
                <label for="birthDate">Doğum Günü</label>
                <input type="date" placeholder="isim" class="input" name="birthDate" id="birthDate" required></input>
                <br><br>
                <label for="deathDate">Ölüm Günü</label>
                <input type="date" placeholder="soyisim" class="input" name="deathDate" id="deathDate" required></input>
            </div>
        </div>
        <div class="row row-btn">
            <button type="button" class="btn-custom-close" onclick="closePopup()">Kapat</button>
            <button type="button" class="btn-custom userClr" onclick="personCreating()">Kaydet</button>
        </div>
    </form>
</div>
    
<button id="addPerson">Kişi Ekle</button>
<div id="container"></div>

<!-- Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <input type="hidden" name="personID" id="personID" value=""/>
    <span class="close">&times;</span>
    <label for="modalFirstName">Adı:</label>
    <input type="text" id="modalFirstName" name="modalFirstName">
    <br>
    <label for="modalLastName">Soyadı:</label>
    <input type="text" id="modalLastName" name="modalLastName">
    <br>
    <label for="modalGender">Cinsiyet:</label>
    <select id="modalGender" name="modalGender">
        <option value="Erkek">Erkek</option>
        <option value="Kadın">Kadın</option>
    </select>
    <br>
    <label for="modalBirthDate">Doğum Günü:</label>
    <input type="date" id="modalBirthDate" name="modalBirthDate">
    <br>
    <label for="modalDeathDate">Ölüm Günü:</label>
    <input type="date" id="modalDeathDate" name="modalDeathDate">
    <div class="modal-buttons">
        <button class="modal-button delete" id="deletePerson">Kullanıcı Sil</button>
        <button class="modal-button edit" id="editPerson">Düzenle</button>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="Script/index.js"></script>
<script>
// PHP'den alınan verileri JavaScript değişkenine aktar
var persons = <?php echo json_encode($result); ?>;

$(document).ready(function() {
    var container = $('#container');
    
    persons.forEach(function(person) {
    var circle = $('<div class="circle"></div>');
    var initials = person.firstName.substring(0, 1) + person.lastName.substring(0, 1);
    var name = $('<p class="circleP"></p>').text(initials);
    circle.append(name);
    circle.on('click', function() {
            showModal(person);
        });
    container.append(circle);
});
});

function showModal(person) {
    $('#personID').val(person.personID);
    $('#modalFirstName').val(person.firstName);
    $('#modalLastName').val(person.lastName);
    $('#modalGender').val(person.gender);
    $('#modalBirthDate').val(person.birthDate);
    $('#modalDeathDate').val(person.deathDate);
    $('#myModal').css('display', 'block');
}
// Modal kapatma
$('.close').on('click', function() {
    $('#myModal').css('display', 'none');
});

$(window).on('click', function(event) {
    if (event.target.id == 'myModal') {
        $('#myModal').css('display', 'none');
    }
});

var scale = 1;
document.addEventListener('wheel', function(event) {
    if (event.deltaY < 0) {
        // Fare tekerleği yukarı kaydırıldığında yakınlaştır
        scale += 0.1;
    } else {
        // Fare tekerleği aşağı kaydırıldığında uzaklaştır
        scale -= 0.1;
    }
    // Minimum ve maksimum ölçek değerlerini belirle
    scale = Math.min(Math.max(0.5, scale), 2);
    document.body.style.transform = `scale(${scale})`;
});
</script>
</body>
</html>