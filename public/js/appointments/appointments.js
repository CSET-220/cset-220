function dateToWords(inputDate) {
    // console.log(inputDate);
    const formattedDate = new Date(inputDate);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedString = formattedDate.toLocaleDateString('en-US', options);
    return formattedString;
}
// each page is 1 day of appointments currentPage and data declared here to become global
let currentPage;
let data;

let todaysDate = new Date();
let todaysDateString = todaysDate.getFullYear() + '-' + String(todaysDate.getMonth() + 1).padStart(2, '0') + '-' + String(todaysDate.getDate()).padStart(2, '0');


// Global variables for updating caption
let patientName = '';
let captionDate = '';
let doctorName = '';

// data is the response from ajax snd page is the current page youre on
function getAppointmentDate(data, page) {
    // get the array of dates that is returned from the groubBy in appointments.by.day from ajax
    const arrOfDates = Object.values(data)
    const day = page + 1
    // get just 1 day out of the array of dates
    return arrOfDates.slice(page,day);
}

// returns the page of whatever date input
function getCurrentPage(data,date){
    const searchDate = new Date(date);
    const search = searchDate.toISOString().slice(0, 10);  
    return Object.keys(data).indexOf(search);
    
}

function createRow(appointment){
    let body = $('#appointment_body')
    // Make row
    const row = $('<tr>');
    $(row).addClass('border-0 border-b border-gray-700 text-gray-800 hover:bg-gray-700 hover:text-white');
    // Make cell for patient name
    const patientCell = $('<td>').text(appointment.patient.user.full_name)
    $(patientCell).addClass('border-0 px-6 py-4 font-medium whitespace-nowrap');
    $(patientCell).attr('data-name', 'patient')
    row.append(patientCell)

    const dateCell = $('<td>').text(appointment.date);
    $(dateCell).addClass('border-0 px-6 py-4');
    $(dateCell).attr('data-name', 'date')
    row.append(dateCell);

    const doctorCell = $('<td>').text(appointment.doctor.full_name);
    $(doctorCell).addClass('border-0 px-6 py-4');
    $(doctorCell).attr('data-name', 'doctor')
    row.append(doctorCell);
    if(appointment.date >= todaysDateString){
        $(doctorCell).attr('colspan', '1');

        const editCell = $('<td>');
        $(editCell).addClass('relative border-0 px-6 py-4');
        row.append(editCell);

        const editBtn = $('<button>').attr({
            id:`appointment_${appointment.id}_dropdown_button`,
            "data-dropdown-toggle": `appointment_${appointment.id}_dropdown`,
            "aria-expanded": "false",
            class: "edit_btn btn dropdown-toggle",
            type: "button"
        });
        $(editBtn).html(`
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
        `)
        const dropdown = $('<div>').attr({
            id: `appointment_${appointment.id}_dropdown`,
            class: "edit_dropdown hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
        }).css({
            position: 'absolute',
            top: '-200%',
            right: '20px',
        });
        dropdown.html(`
            <div class="py-1 text-sm text-gray-700 dark:text-gray-200">
                <form action="" id="${appointment.id}" method="post" class="delete_apt_btn">
                    <input class="block py-2 px-4 text-sm hover:bg-gray-600 text-gray-200 hover:text-white" type="submit" value="Cancel Appointment">
                </form>
            </div>
            <div class="py-1 text-sm text-gray-700 dark:text-gray-200">
                <a id="appointment_edit_btn" class="cursor-pointer block py-2 px-4 text-sm hover:bg-gray-600 text-gray-200 hover:text-white">Reschedule Appointment</a>
            </div>
        `);
        editCell.append(editBtn);
        editCell.append(dropdown);
    }
    
    else{
        $(doctorCell).attr('colspan', '2');
    }
    body.append(row)
}

// takes respsonse and currentPage from ajax and creates rows for each appointment
function displayGroupByTable(data, page) {
    const allAppointments = getAppointmentDate(data, page);
    // console.log(allAppointments);
    let body = $('#appointment_body')
    body.empty()
    allAppointments.forEach((appointments, index) => {
        appointments.forEach(appointment => {
            // create row in the table
            createRow(appointment);
        })
    });
}
function displayPatientAppointments(appointments){
    let body = $('#appointment_body');
    body.empty()
    appointments.forEach((appointment) => {
        // Make row
        createRow(appointment);
    });
}

// updates the caption text
function updateCaption(){
    let captionText = 'Schedule Appointment'
    console.log(doctorName);
    if (patientName && patientName !== 'New Appointment') {
        captionText += ` for ${patientName}`;
    }

    if (captionDate) {
        captionText += ` on ${dateToWords(captionDate)}`;
    }

    if (doctorName && doctorName !== 'Choose Doctor') {
        captionText += ` with Dr. ${doctorName}`;
    }

    $('#table_caption').text(captionText);
}

// GETS THE INFO FOR APPOINTMENTS WHEN PAGE LOADS
function refreshAppointments(){
    $.ajax({
        type: "get",
        url: "/api/appointments/by/day",
        dataType: "json",
        success: function (response) {
            data = response;
            currentPage = getCurrentPage(response,todaysDateString)
            displayGroupByTable(data,currentPage)
        },
    });
}

$(document).ready(function () {
    // When page loads get appointments
    refreshAppointments()


    // EVENT LISTENERS
    // Goes to next day from groupby 
    $('#nextPageButton').click(function() {
        if (currentPage < Object.keys(data).length - 1) { 
            currentPage++;
            displayGroupByTable(data, currentPage);
        }
    });
    
    // Goes to prev day
    $('#previousPageButton').click(function() {
        if (currentPage > 1 || (currentPage === 1 && Object.keys(data).length > 0)) {
            currentPage--;
            displayGroupByTable(data, currentPage);
        }
    });


    // When the patient name dropdown changes update the caption
    // and update the table with all prev patient appointments
    $('#patient_id').on('change', function () {
        patientName = $('#patient_id option:selected').text();
        let patient_id = $(this).val();
        console.log(patient_id);
        updateCaption();
        if (patientName === "New Appointment") {
            currentPage = getCurrentPage(data, todaysDateString);
            displayGroupByTable(data,currentPage)
        }
        else{
            $.ajax({
                type: "get",
                url: "/api/appointments/" + patient_id,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if ($('#patient_id').val()) {
                        displayPatientAppointments(response);
                    }
                }
            });
        }

    });
    

    // when the date input changes update caption and get doctors working that day
    // - if patient name is blank show all appointments on that day
    $('#apt_date').on('changeDate', function() {
        captionDate = $(this).val();
        patientName = $('#patient_id').val()
        updateCaption();
        if(!patientName){
            currentPage = getCurrentPage(data,captionDate);
            displayGroupByTable(data,currentPage);
        }
        $.ajax({
            type: "get",
            url: "/api/appointments/doctor/onShift",
            data: {
                'apt_date': captionDate
            },
            dataType: "json",
            success: function (response) {
                let drDropdown = $('#doctor_id');
                drDropdown.empty();
                if(Object.keys(response).length > 0){
                    // console.log(response.doctor.full_name);
                    response.forEach(appointment => {
                        doctorName = appointment.doctor.full_name
                        drOption = $('<option>').val(appointment.doctor.id).text(appointment.doctor.full_name).attr('selected','selected')
                        
                    })
                    drDropdown.removeClass('border-red-500')
                    updateCaption()
                }
                else{
                    drDropdown.addClass('border-red-500')
                    drOption =  $('<option>').text("No Doctors Available That Day").attr('selected','selected')
                }
                drDropdown.append(drOption);
            }
        });
    });



    // Click anywhere to close edit dropdown
    $(document).click(function(e) {
        $('.edit_dropdown').addClass('hidden');
        
    });
    // Opens the edit dropdown and closes any other opened
    $(document).on('click','.edit_btn', function (e) {
        $('.edit_dropdown').addClass('hidden');
        $(this).next('.edit_dropdown').toggleClass('hidden');
        e.stopPropagation()
    });


    // Turns row into form for
    $(document).on('click','#appointment_edit_btn', function (e) {
        var row = $(this).closest('tr');
        console.log(row);
    
        row.find('td').each(function() {
            // Change each cell to form input then ajax to PUT route
            cellName = $(this).attr('data-name');
            var select = $('<select>');
            select.addClass('block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer')

            if(cellName === "patient"){
                $('select#patient_id option').each(function() {
                    var value = $(this).val();
                    var text = $(this).text();
                    select.append(new Option(text,value))
                })
                // console.log(this, 'PATIENT');
                $(this).html(select);
            }
            else if(cellName === "date"){
                var input = $('<input>');
                input = new Datepicker(input);
                // input.attr('id', 'edit_apt_datepicker');
                // input.addClass('border text-sm rounded-lg  block w-full ps-10 p-2.5  bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500');
                // console.log(this,'DATE');
                $(this).html(input)
                // $(this).replaceWith(input);
                // $('#edit_apt_datepicker').datepicker({
                //     dateFormat: "yy-mm-dd"
                // });
            }
            console.log(cellName);
        });
    });


    // AJAX REQUEST TO DELETE ROUTE
    // Deletes appts
    $(document).on('submit', '.delete_apt_btn', function(e) {
        e.preventDefault();
        let aptID = $(this).attr('id');
        console.log(aptID);
        $.ajax({
            url: '/api/appointments/' + aptID,
            type: 'POST',
            data: {
                _method: 'DELETE'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#table_sub_caption').text('Appointment Canceled Successfully');
                refreshAppointments()
            }
        });
    });
    
});