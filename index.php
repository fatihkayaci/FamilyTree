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
            
            <label for="parentID">Ebeveyn ID:</label>
            <input type="text" id="parentID" name="parentID"><br><br>
            
            <input type="button" name="saveButton" id="saveButton" value="Kişi Ekle">
        </div>
    </div>

    <!-- JavaScript -->
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
                firstName: $('input[name="firstName"]').val(), // Textarea için doğru seçici
                lastName: $('input[name="lastName"]').val(), // Textarea için doğru seçici
                birthDate: $('input[name="birthDate"]').val(), // Textarea için doğru seçici
                deathDate: $('input[name="deathDate"]').val(), // Textarea için doğru seçici
                parentID: $('input[name="parentID"]').val(), // Textarea için doğru seçici
            };

            $.ajax({
                url: 'Controller/personalSave.php',
                type: 'POST',
                data: {
                    firstName: formData.firstName,
                    lastName: formData.lastName,
                    birthDate: formData.birthDate, 
                    deathDate: formData.deathDate,
                    parentID: formData.parentID 
                },
                success: function(response) {
                    alert(response);
                },
                error: function(error) {
                    console.error("AJAX hatası: ", error);
                }
            });
        });
        });
    </script>
</body>
</html>