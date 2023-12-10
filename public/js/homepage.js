$(document).ready(function () {
    let wasPatient = $('#user_type').val();
    if(wasPatient === 'patient'){
        $('#additional_patient_info').slideDown(500);
    }
});

$('#user_type').on('change', function () {
    type = $(this).val();

    if(type === 'patient'){
        $('#additional_patient_info').slideDown(500);
    }
    else{
        $('#additional_patient_info').slideUp(500);
    }
});


$('#phone_number, #emergency_contact').on('input', function () {
    let phoneNumber = this.value.replace(/\D/g, '')
    
    if (phoneNumber.length > 10) {
        phoneNumber = phoneNumber.substring(0, 10);
    }
    
    // Format the phone number as (XXX) XXX-XXXX
    let formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{0,3})(\d{0,4})/, function(match, p1, p2, p3) {
        let formatted = '(' + p1;
        if (p2) formatted += ') ' + p2;
        if (p3) formatted += '-' + p3;
        return formatted;
    });
    
    
    $(this).val(formattedPhoneNumber);
    console.log(phoneNumber)
});
$('#emergency_contact').on('input', function () {
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

$('#password').on('focus', function () {
    $('.password_requirements').slideDown(500);

});
$('#password').blur(function() {
    $('.password_requirements').slideUp(500);
});
$('#password').keyup(function() {
    var password = $(this).val();

    // length requirement
    if (password.length >= 8) {
        $('.length_req').removeClass('text-gray-500').addClass('text-green-500');
    } else {
        $('.length_req').removeClass('text-green-500').addClass('text-gray-500');
    }

    // number requirement
    if (/\d/.test(password)) {
        $('.number_req').removeClass('text-gray-500').addClass('text-green-500');
    } else {
        $('.number_req').removeClass('text-green-500').addClass('text-gray-500');
    }

    // lowercase requirement
    if (/[a-z]/.test(password)) {
        $('.lower_req').removeClass('text-gray-500').addClass('text-green-500');
    } else {
        $('.lower_req').removeClass('text-green-500').addClass('text-gray-500');
    }

    // uppercase requirement
    if (/[A-Z]/.test(password)) {
        $('.upper_req').removeClass('text-gray-500').addClass('text-green-500');
    } else {
        $('.upper_req').removeClass('text-green-500').addClass('text-gray-500');
    }

    // special requirement
    if (/[!@#?]/.test(password)) {
        $('.special_req').removeClass('text-gray-500').addClass('text-green-500');
    } else {
        $('.special_req').removeClass('text-green-500').addClass('text-gray-500');
    }
});