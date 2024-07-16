$('#addPerson').click(function () {
    $('#popup').show().css('display', 'flex').delay(100).queue(function (next) {
        $('body').css('overflow', 'hidden');
        $('#popup').css('opacity', '1');
        $('#userForm').css('opacity', '1');
        $('#userForm').css('transform', 'translateY(0)');
        next();
    });
});
function personCreating(){
    var newCircle = document.createElement("div");
    newCircle.classList.add("circle");
    document.getElementById("container").appendChild(newCircle);

    var formData = {
        firstName: $('input[name="firstName"]').val(), // Textarea için doğru seçici
        lastName: $('input[name="lastName"]').val(),
        gender: $('#gender').val(),
        birthDate: $('input[name="birthDate"]').val(), // "promise" adında bir input olduğu varsayılıyor
        deathDate: $('input[name="deathDate"]').val()
    };
    console.log(formData);

    $.ajax({
        url: './Controller/personalSave.php',
        type: 'POST',
        data: {
            firstName: formData.firstName,
            lastName: formData.lastName,
            gender: formData.gender,
            birthDate: formData.birthDate,
            deathDate: formData.deathDate // voters'ı POST verisine ekliyoruz
        },
        success: function(response) {
            location.reload();
        },
        error: function(error) {
            console.error("AJAX hatası: ", error);
        }
    });
}
function closePopup() {
    $('#userForm').css('opacity', '0').css('transform', 'translateY(-180px)').delay(100).queue(function (next) {
        $('#popup').css('opacity', '0').delay(300).queue(function (nextInner) {
            $(this).hide().css('display', 'none');
            nextInner();
            $('body').css('overflow', 'auto');
        });
        next();
    });
}
$('#deletePerson').click(function() {
    var personID = $('input[name="personID"]').val();
    $.ajax({
        url: './Controller/personalDelete.php',
        type: 'POST',
        data: {
            personID: personID
        },
        success: function(response) {
            alert(response);
            location.reload();
        },
        error: function(error) {
            console.error("AJAX hatası: ", error);
        }
    });
});

$('#editPerson').click(function() {
    var personID = $('input[name="personID"]').val();
    var firstName = $('input[name="modalFirstName"]').val();
    var lastName= $('input[name="modalLastName"]').val();
    var gender = $('input[name="modalGender"]').val();
    var birthDate = $('input[name="modalBirthDate"]').val();
    var deathDate = $('input[name="modalDeathDate"]').val();
    console.log(personID+ firstName+ lastName+ gender+ birthDate+ deathDate);
    $.ajax({
        url: './Controller/personalUpdate.php',
        type: 'POST',
        data: {
            personID: personID,
            firstName: firstName,
            lastName: lastName,
            birthDate: birthDate,
            deathDate: deathDate
        },
        success: function(response) {
            console.log(response);
            // location.reload();
        },
        error: function(error) {
            console.error("AJAX hatası: ", error);
        }
    });
});


   