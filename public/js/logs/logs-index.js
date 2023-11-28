document.querySelectorAll('input[type=checkbox]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var patientId = checkbox.getAttribute('data-patient-id');
        var logType = checkbox.getAttribute('data-log-type');
        var status = this.checked ? 1 : 0;
        var date = this.getAttribute('data-date');
        $.ajax({
            url: '/api/updateLog',
            type: 'POST',
            data: {
                patient_id: patientId,
                log_type: logType,
                status: status,
                date: date,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response)
            },
            error: function(error) {
                console.log(error)
            }
        })
    })
})
$(document).ready(function() {
    $('#myTable').DataTable();
});