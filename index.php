<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery CDN -->

    
</head>
<body>
    <?php
        session_start();
        include("dbConnection.php");
        
        $sql = "SELECT * FROM tbl_personal";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql2 = "SELECT * FROM tbl_relationship";
        $stmt = $conn->prepare($sql2);
        $stmt->execute();
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!-- Popup için buton -->
    <button id="openPopup">Kişi Ekle</button>

    <!-- Popup içeriği -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">&times;</span>
            <label for="firstName">Adı:</label>
            <input type="text" id="firstName" name="firstName" required><br><br>
            
            <label for="lastName">Soyadı:</label>
            <input type="text" id="lastName" name="lastName" required><br><br>
            
            <label for="gender">Cinsiyet:</label>
            <select id="gender" name="gender" required>
                <option value="M">Erkek</option>
                <option value="F">Kadın</option>
            </select><br><br>
            
            <label for="birthDate">Doğum Tarihi:</label>
            <input type="date" id="birthDate" name="birthDate" required><br><br>
            
            <label for="deathDate">Ölüm Tarihi:</label>
            <input type="date" id="deathDate" name="deathDate"><br><br>
            
            <input type="button" name="saveButton" id="saveButton" value="Kişi Ekle">
        </div>
    </div>
    <div id="circleContainer">
        <?php
        if (!empty($result)) {
            foreach ($result as $row) {
                $personID = $row['personID'];
                $firstName = $row['firstName'];
                $lastName = $row['lastName'];
                $birthDate = $row['birthDate'];
                $deathDate = $row['deathDate'];
                $gender = $row['gender'];
        
                $initials = strtoupper($firstName[0] . $lastName[0]);
                ?>
                <div class="circle" data-personid="<?php echo $personID; ?>"><?php echo $initials; ?></div>
        
                <div id="modal<?php echo $personID; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" data-personid="<?php echo $personID; ?>">&times;</span>
                        <input type="hidden" name="personID" value="<?php echo $personID; ?>"> <!-- Hidden input for personID -->
        
                        <label for="editFirstName<?php echo $personID; ?>">Adı:</label>
                        <input type="text" id="editFirstName<?php echo $personID; ?>" name="editFirstName<?php echo $personID; ?>" value="<?php echo $firstName; ?>" required><br><br>
        
                        <label for="editLastName<?php echo $personID; ?>">Soyadı:</label>
                        <input type="text" id="editLastName<?php echo $personID; ?>" name="editLastName<?php echo $personID; ?>" value="<?php echo $lastName; ?>" required><br><br>
        
                        <label for="editGender<?php echo $personID; ?>">Cinsiyet:</label>
                        <select id="editGender<?php echo $personID; ?>" name="editGender<?php echo $personID; ?>" required>
                            <option value="M"<?php echo ($gender == 'M' ? ' selected' : ''); ?>>Erkek</option>
                            <option value="F"<?php echo ($gender == 'F' ? ' selected' : ''); ?>>Kadın</option>
                        </select><br><br>
        
                        <label for="editBirthDate<?php echo $personID; ?>">Doğum Tarihi:</label>
                        <input type="date" id="editBirthDate<?php echo $personID; ?>" name="editBirthDate<?php echo $personID; ?>" value="<?php echo $birthDate; ?>" required><br><br>
        
                        <label for="editDeathDate<?php echo $personID; ?>">Ölüm Tarihi:</label>
                        <input type="date" id="editDeathDate<?php echo $personID; ?>" name="editDeathDate<?php echo $personID; ?>" value="<?php echo $deathDate; ?>"><br><br>
        
                        <button class="updateButton" data-personid="<?php echo $personID; ?>">Güncelle</button>
                        <button class="deleteButton" data-personid="<?php echo $personID; ?>">Sil</button>
                    </div><!-- modal-content -->
                </div><!-- modal -->
                <?php
            }
        } else {
            echo "Kayıt bulunamadı.";
        }
        ?>
    
    <script>
    // Popup açma işlemi
    var popup = document.getElementById('popup');
    var openPopupBtn = document.getElementById('openPopup');
    var closePopupBtn = document.getElementById('closePopup');

    openPopupBtn.addEventListener('click', function() {
        popup.style.display = 'block';
    });

    closePopupBtn.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    // Form gönderme işlemi
    $(document).ready(function() {
        $('#saveButton').click(function() {
            var formData = {
                firstName: $('input[name="firstName"]').val(),
                lastName: $('input[name="lastName"]').val(),
                birthDate: $('input[name="birthDate"]').val(),
                deathDate: $('input[name="deathDate"]').val(),
            };

            $.ajax({
                url: 'Controller/personalSave.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response);
                    // Popup'u kapat
                    popup.style.display = 'none';
                    // Formu temizle
                    $('input[name="firstName"]').val('');
                    $('input[name="lastName"]').val('');
                    $('input[name="birthDate"]').val('');
                    $('input[name="deathDate"]').val('');
                      // Yeni yuvarlak elemanı oluştur ve ekle
                      var newCircle = document.createElement('div');
                    newCircle.className = 'circle';
                    newCircle.innerText = person.firstName.charAt(0) + person.lastName.charAt(0);
                    document.getElementById('circleContainer').appendChild(newCircle);
                
                },
                error: function(error) {
                    console.error("AJAX hatası: ", error);
                }
            });
        });
         // Modal açma işlemleri
    $(document).on('click', '.circle', function() {
        var personID = $(this).data('personid');
        $('#modal' + personID).css('display', 'block');
        // Modal içindeki inputlara mevcut verileri yaz
        $('#editFirstName' + personID).val($('#firstName' + personID).text());
        $('#editLastName' + personID).val($('#lastName' + personID).text());
        $('#editGender' + personID).val($('#gender' + personID).text());
        $('#editBirthDate' + personID).val($('#birthDate' + personID).text());
        $('#editDeathDate' + personID).val($('#deathDate' + personID).text());
    });

    // Modal kapatma işlemleri
    $(document).on('click', '.close', function() {
        var personID = $(this).data('personid');
        $('#modal' + personID).css('display', 'none');
    });

    // Güncelleme işlemi
    $(document).on('click', '.updateButton', function() {
        var personID = $(this).data('personid');
        var formData = {
            personID: personID,
            firstName: $('#editFirstName' + personID).val(),
            lastName: $('#editLastName' + personID).val(),
            birthDate: $('#editBirthDate' + personID).val(),
            deathDate: $('#editDeathDate' + personID).val(),
            gender: $('#editGender' + personID).val()
        };

        $.ajax({
            url: 'Controller/updatePerson.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert(response);
                // Modal'ı kapat
                $('#modal' + personID).css('display', 'none');
                // Veriyi güncelle
                $('#firstName' + personID).text(formData.firstName);
                $('#lastName' + personID).text(formData.lastName);
                $('#gender' + personID).text(formData.gender);
                $('#birthDate' + personID).text(formData.birthDate);
                $('#deathDate' + personID).text(formData.deathDate);
            },
            error: function(error) {
                console.error("AJAX hatası: ", error);
            }
        });
    });

    // Silme işlemi
    $(document).on('click', '.deleteButton', function() {
        var personID = $(this).data('personid');
        var confirmDelete = confirm("Bu kaydı silmek istediğinizden emin misiniz?");
        if (confirmDelete) {
            $.ajax({
                url: 'Controller/deletePerson.php',
                type: 'POST',
                data: { personID: personID },
                success: function(response) {
                    alert(response);
                    // Modal'ı kapat
                    $('#modal' + personID).css('display', 'none');
                    // Yuvarlağı kaldır
                    $('.circle[data-personid="' + personID + '"]').remove();
                },
                error: function(error) {
                    console.error("AJAX hatası: ", error);
                }
            });
        }
    });
    });
    
</script>

</body>
</html>