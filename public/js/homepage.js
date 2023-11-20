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


$('#phone_number').on('input', function () {
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
    
    // Format the phone number as (XXX) XXX-XXXX
    let formattedPhoneNumber = phoneNumber.replace(/(\d{3})(\d{0,3})(\d{0,4})/, function(match, p1, p2, p3) {
        let formatted = '(' + p1;
        if (p2) formatted += ') ' + p2;
        if (p3) formatted += '-' + p3;
        return formatted;
    });
    
    
    $(this).val(formattedPhoneNumber);
});
