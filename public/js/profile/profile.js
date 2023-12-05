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

$('#fam_code_search_btn').on('click', function () {
    let search = $('#fam_code_search').val();
    let famId = $('#fam_code_search').attr('data-family-id')
    let slider = $('#slider')
    console.log(famId);

    $.ajax({
        type: "get",
        url: `/api/users/${famId}/family/connect`,
        data: {
            fam_code_search: search,
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response.length < 1){
                // console.log("ITS EMPTY");
                let message = $('<p>').text('No Patients Found');
                div.append(message)
                // console.log(div.html());
            }
            else{
                response.forEach(familyMember => {
                    let carouselItem = $('<div>').addClass('carousel-item');
                    carouselItem.text(familyMember.familyMemberDetail);
                    slider.append(carouselItem);

                });
                new Carousel(slider);
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the data-modal-hide attribute
    var closeButtons = document.querySelectorAll('[data-modal-hide]');

    closeButtons.forEach(btn => {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            var modalId = this.getAttribute('data-modal-hide');
        })
    });
    // Loop through the elements
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

