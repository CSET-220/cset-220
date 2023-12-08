$('#edit_profile_btn').on('click', function () {
    var editUserForm = $('#edit_user_form');
    var userInfo = $('#user_info');
    userInfo.slideToggle(500);
    editUserForm.slideToggle(500)
});

$('#user_phone, #family_phone').on('input', function () {
    let phoneNumber = this.value.replace(/\D/g, '')
    
    if (phoneNumber.length > 10) {
        phoneNumber = phoneNumber.substring(0, 10);
    }
    
    // Formats phone to (XXX) XXX-XXXX
    let formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{0,3})(\d{0,4})/, function(match, p1, p2, p3) {
        let formatted = '(' + p1;
        if (p2) formatted += ') ' + p2;
        if (p3) formatted += '-' + p3;
        return formatted;
    });
    
    
    $(this).val(formattedPhoneNumber);
});


$('#show_patient_search').on('click', function () {
    $('#patient_search_form').slideToggle(500);
});


document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the data-modal-hide attribute
    var closeButtons = document.querySelectorAll('[data-modal-hide]');
    for (var i = 0; i < closeButtons.length; i++) {
        // Add a click event listener to each element
        closeButtons[i].addEventListener('click', function (event) {
            var backdrop = $('[modal-backdrop]')
            if(backdrop){
                backdrop.addClass('hidden')
            }
        });
    }
});

