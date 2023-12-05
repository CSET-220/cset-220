document.addEventListener('DOMContentLoaded', () => {
    // patientId is stored in a global variable in the view
    const datePicker = document.getElementById('date-picker');
    datePicker.value = new Date();
    let originalRowHTML = null;
    let rowCleared = false;
    
    datePicker.addEventListener('changeDate', () => {
        const date = datePicker.value;
        const url = `/api/patients/${patientId}/${date}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const row = document.getElementById('patient-log-row');
                
                if (data.log) {
                    if (rowCleared) {
                        row.innerHTML = originalRowHTML;
                        rowCleared = false;
                    }

                    if (data.appointment) {
                        row.cells[0].textContent = data.doctor;
                        row.cells[1].innerHTML = getCheckMarkIfNotNull(data.appointment.comments);
                    }
                    else {
                        row.cells[0].textContent = 'N/A';
                        row.cells[1].textContent = 'N/A';
                    }
                    row.cells[2].textContent = data.caregiver;
                    row.cells[3].innerHTML = getCheckMarkIfNotNull(data.log.morning_med);
                    row.cells[4].innerHTML = getCheckMarkIfNotNull(data.log.afternoon_med);
                    row.cells[5].innerHTML = getCheckMarkIfNotNull(data.log.night_med);
                    row.cells[6].innerHTML = getCheckMarkIfNotNull(data.log.breakfast);
                    row.cells[7].innerHTML = getCheckMarkIfNotNull(data.log.lunch);
                    row.cells[8].innerHTML = getCheckMarkIfNotNull(data.log.dinner);
                }
                else {
                    if (!rowCleared) {
                        originalRowHTML = row.innerHTML;
                        rowCleared = true;
                    }
                    row.innerHTML = `<td colspan="69">No logs for this day</td>`;
                }
            })
            .catch((error) => {
                console.error('Big ol Error: ', error);
            });
    })

    // resetting the datepicker date when clicking the clear button
    document.getElementById('clear').addEventListener('click', () => {
        datePicker.datepicker.setDate('today');
    })
});

function getCheckMarkIfNotNull(value) {
    const checkMark = (
        `<svg class="w-6 h-6 text-gray-800 dark:text-white mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
        </svg>`
    )
    return value ? checkMark : '';
}