// converts date to MonthName DD YYYY
function dateToWords(inputDate) {
    // console.log(inputDate);
    const [year, month, day] = inputDate.split('-');
    let formattedDate = new Date(year, month - 1, day);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedString = formattedDate.toLocaleDateString('en-US', options);
    return formattedString;
}
// Checks if appointment date is today or not
function isTodayAppt(appt_date){
    // console.log(appt_date);
    // appt_date = new Date(appt_date)
    appt_date.setHours(24,0,0,0)
    let today = new Date()
    today.setHours(0,0,0,0)
    return ( appt_date.getDate() === today.getDate() && appt_date.getMonth() === today.getMonth() && appt_date.getFullYear() === today.getFullYear() )
}
// CLOSES MODAL
$(document).on('click', '#close_appointment', function () {
    $('#appointment_details').addClass('hidden');
});

// LISTENS FOR SEE PATIENT BTN CLICK TO SHOW THE CONDUCT APPOINTMENT MODAL
$(document).on('click', '#show_conduct_apt', function () {
    // Get encrypted appointment data from data-modal-content attribute
    let data = $(this.parentElement).attr('data-modal-content')
    let aptInfo = JSON.parse(decodeURIComponent(data)) 
    $.ajax({
        type: "get",
        url: "/api/prescriptions",
        dataType: "json",
        success: function (response) {
            displayConductAppointment(aptInfo,response);
        }
    });
});


// Displays that patients past appointments in a modal with 2 appointments for each page
function displayAppointmentModal(appointments){
    $('#appointment_list').html('');
    appointments.forEach(appointment => {
        // Checks statusText and adds classes depending on what the status says
        let statusClasses = {
            'Not Seen': 'text-white bg-blue-600',
            'Unattended': 'text-red-500 bg-gray-800',
            'Attended': 'bg-green-400'
        };
        console.log(appointment.date, 'APPOINTMENT DATE');
        // Changing side text depending on if patient attended appointment or not
        // Not using isApptToday because need to see if its less than or greater than
        let today = new Date();
        today.setHours(0, 0, 0, 0);
        let displayAptDate = dateToWords(appointment.date)
        // Will display Not Seen, Attended or Unattended
        let statusText = '';
        // Will display Conduct Appointment if patient was not seen
        let appointmentLabel = 'Patient Check-Up'
        // Will use to display See Patient Button
        let checkDate = new Date(appointment.date)
        
        // Patient was seen if a comment was written
        if(appointment.comments === "" || appointment.comments === null){
            newDateCheck = new Date(appointment.date)
            newDateCheck.setHours(24,0,0,0)
            if(newDateCheck >= today){
                statusText = 'Not Seen'
                appointmentLabel = 'Conduct Appointment'
            }
            else{
                statusText = 'Unattended'
            }
        }
        else{
            statusText = 'Attended'
        }

        let statusClass = statusClasses[statusText]

        let info = `
        <li class="mb-10 ms-8" data-modal-content="${encodeURIComponent(JSON.stringify(appointments))}">            
            <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                <svg class="w-2.5 h-2.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/></svg>
            </span>
            <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900">${appointmentLabel}
                <span class="text-sm font-medium mr-2 px-2.5 py-0.5 rounded ms-3 ${statusClass}">${statusText}</span>
            </h3>
            <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">${displayAptDate}</time>
            <p class="block mb-3 text-sm font-normal text-gray-500 dark:text-gray-400">${appointment.comments ?? ""}</p>
        `
        if(isTodayAppt(checkDate) && !appointment.comments){
            // console.log("SHOW SEE PATIENT");
            info += `
                
                <a id="show_conduct_apt" class="cursor-pointer my-4 inline-flex items-center py-2 px-3 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-gray-700 bg-gray-700 text-gray-400 border-gray-600 hover:text-white hover:bg-gray-600">
                    <svg class="w-3 h-3 me-1.5" aria-hidden="true" viewBox="0 0 30 45" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.50012 45C11.6401 45 15.0002 41.6399 15.0002 37.4999V29.9999H7.50012C3.36009 29.9999 0 33.3599 0 37.4999C0 41.6399 3.36009 45 7.50012 45Z" fill="#0ACF83"/><path d="M0 22.5C0 18.36 3.36009 14.9999 7.50012 14.9999H15.0002V29.9999H7.50012C3.36009 30.0001 0 26.64 0 22.5Z" fill="#A259FF"/><path d="M0 7.50006C0 3.36006 3.36009 0 7.50012 0H15.0002V14.9999H7.50012C3.36009 14.9999 0 11.6401 0 7.50006Z" fill="#F24E1E"/><path d="M15.0002 0H22.4999C26.6399 0 30 3.36006 30 7.50006C30 11.6401 26.6399 14.9999 22.4999 14.9999L15.0002 14.9999V0Z" fill="#FF7262"/><path d="M30 22.5C30 26.64 26.6399 30 22.4999 30C18.3599 30 14.9998 26.64 14.9998 22.5C14.9998 18.36 18.3599 14.9999 22.4999 14.9999C26.6399 14.9999 30 18.36 30 22.5Z" fill="#1ABCFE"/></svg>
                    See Patient
                </a>
                
            `
        }

        info += `</li>`
        $('#appointment_list').append(info);
    });
};


// Uses links from getNextApptPage and displays them
function displayPageButtons(links){
    if(links.length > 1){
        var pageBtns = '<ul class="pagination flex items-center justify-center space-x-2 p-4">';

        // loop through each pagination link
        links.forEach(link => {
            pageBtns += '<li class="inline-flex items-center justify-center text-sm py-2 px-3 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white ' + (link.active ? 'active text-gray-600 bg-primary-50 border border-primary-300 hover:bg-gray-100 hover:text-gray-700' : '') + '">';
            
            // If on current page, page num is just text
            if (link.active) {
                pageBtns += `<span class="page-link">${link.label}</span>`;
            } else {
                pageBtns += `<a class="page-link" href="#" data-page-url="${link.url}">${link.label}</a>`;
            }
            
            pageBtns += '</li>';
        });

        pageBtns += '</ul>';
        $('#appointment_pagination').html(pageBtns);

        $('#appointment_pagination a').on('click', function (e) {
            e.preventDefault();
            var pageUrl = $(this).data('page-url');
            getNextApptPage(pageUrl);
        });
    }
}


// Gets page links from paginate() and displays them
function getNextApptPage(page_url){
    $.ajax({
        type: "get",
        url: page_url,
        dataType: "json",
        success: function (response) {
            // CHECKS IF DATA AND PAGINATION LINKS ARE THERE
            if (response.hasOwnProperty('data')) {
                displayAppointmentModal(response.data);
            }
            if (response.hasOwnProperty('links')) {
                displayPageButtons(response.links);
            }
        }
    });
}


// DISPLAYS THE MAIN MODAL
function displayModal(appointment) {
    let date_of_birth = dateToWords(appointment.patient.user.dob) 
    $('#appointment_details').html(
        `
        <div class="relative p-4 w-full max-w-lg max-h-full">

            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 rounded-t border-gray-800">
                    <h3 class="text-lg font-semibold text-white">${appointment.patient_name} - ${date_of_birth}</h3>
                    <button id="close_appointment" class="close_apt text-gray-400 bg-transparent rounded-lg text-sm h-8 inline-flex justify-center items-center hover:bg-gray-600 hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span id="close_modal" class="sr-only">Close modal</span>
                    </button>
                </div>

                <div id="appointment_body" class="p-4 md:p-5">
                    <ol id="appointment_list" data-modal-patient="${encodeURIComponent(JSON.stringify(appointment.patient))}" class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5"></ol>
                </div>
                <div id="appointment_pagination" class="my-4"></div>
            </div>
        </div>
        `
    );
    $.ajax({
        type: "get",
        url: "/api/appointments/" + appointment.patient_id,
        data: "data",
        dataType: "json",
        success: function (response) {
            if (response.hasOwnProperty('data')) {
                // console.log(response.data);
                displayAppointmentModal(response.data);
            }
            if (response.hasOwnProperty('links')) {
                displayPageButtons(response.links);
            }
        }
    });
    // DISPLAY MODAL
    $('#appointment_details').removeClass('hidden');
        
}


function displayConductAppointment(appointment,prescriptions){
    let data = $('#appointment_list').attr('data-modal-patient')
    let patientInfo = JSON.parse(decodeURIComponent(data))
    if(appointment.length > 1){
    
        console.log(appointment[1].afternoon_med);
    }
        // $('#appointment_details').attr('data-modal-backdrop', 'static');

    $('#appointment_details').html(`
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative rounded-lg shadow bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                    <h3 class="text-lg font-semibold text-white">
                        Conduct Appointment - ${patientInfo.user.first_name} ${patientInfo.user.last_name}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="appointment_details">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="/api/appointments/${appointment[0].id}/conduct" method="post" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="morning_prescription_name" class="block mb-2 text-sm font-medium text-white">Morning Prescription</label>
                            <div class="flex justify-between">
                                <select id="morning_prescription_name" name="morning_prescription_name" class=" border mr-4 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">Select Prescription</option>

                                </select>
                                <select id="morning_prescription_dosage" name="morning_prescription_id" class=" border  text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">Select Dosage</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="afternoon_prescription_name" class="block mb-2 text-sm font-medium text-white">Afternoon Prescription</label>
                            <div class="flex justify-between">
                                <select id="afternoon_prescription_name" name="afternoon_prescription_name" class=" border mr-4 text-sm rounded-lg  block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Prescription</option>

                                </select>
                                <select id="afternoon_prescription_dosage" name="afternoon_prescription_id" class=" border  text-sm rounded-lg  block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Dosage</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="night_prescription_name" class="block mb-2 text-sm font-medium text-white">Night Prescription</label>
                            <div class="flex justify-between">
                                <select id="night_prescription_name" name="night_prescription_name" class=" border mr-4 text-sm rounded-lg block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Prescription</option>

                                </select>
                                <select id="night_prescription_dosage" name="night_prescription_id" class=" border  text-sm rounded-lg block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">Select Dosage</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="comment" class="block mb-2 text-sm font-medium text-white">Appointment Comments</label>
                            <textarea id="comment" name="comment" rows="4" class="block p-2.5 w-full text-sm rounded-lg border bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Appointment Comments" required></textarea>                    
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Complete Appointment
                    </button>
                    
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                </form>
            </div>
        </div>
    `)
    fillPrescriptions(prescriptions,appointment[1])
}


// Gets prescription names to populate name dropdown
function fillPrescriptions(prescriptions, prevApt){
    ['morning', 'afternoon', 'night'].forEach(time => {
        var nameSelect = $(`#${time}_prescription_name`);
        var doseSelect = $(`#${time}_prescription_dosage`);

        prescriptions.forEach(prescription => {
            var nameOption = new Option(prescription.medication_name, prescription.medication_name);
            nameSelect.append(nameOption);
            if(prevApt){
                if(prescription.id === prevApt[`${time}_med`]){
                    // console.log("SAME",time);
                    $(nameOption).prop('selected',true);
                    var doseOption = new Option(`${prescription.medication_dosage}mg`,prescription.id);
                    doseSelect.append(doseOption);
                    $(doseOption).prop('selected',true);

                }
            }        
        });
        removeDuplicateOptions(nameSelect);
    });
}



// Gets prescription dosages by prescription name to display available dosages
['morning', 'afternoon', 'night'].forEach(time => {
    $(document).on('change', `#${time}_prescription_name`, function () {
        var medicationName = $(this).val();
        // console.log(medicationName);
        if(medicationName === ""){
            $(`#${time}_prescription_dosage`).empty()
        }
        else{
            $.ajax({
                type: "get",
                url: '/api/prescriptions/' + medicationName +'/dosage',
                success: function(response) {
                    var selectDosage = $(`#${time}_prescription_dosage`);
                    selectDosage.empty();
                    response.forEach(prescription => {
                        selectDosage.append($('<option>', { 
                            value: prescription.id,
                            text : `${prescription.medication_dosage}mg` 
                        }));
                    });
                }
            });
        }
    });
});

function removeDuplicateOptions(selectElement) {
    var usedNames = {};
    selectElement.children('option').each(function () {
        if (usedNames[this.text] && !$(this).is(':selected')) {
            $(this).remove();
        } else {
            usedNames[this.text] = this.value;
        }
    });
}