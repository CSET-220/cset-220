$(document).ready(function() {
    console.log("anything");
    $("#patient_id").on("change", function () {
        $.ajax({
            type: "get",
            url: "/api/admin/patientInfo",
            data: {patient_id: $(this).val()},
            success: function (response) {
                console.log(response);
                $("#patient_name").val(response[0].patient_name);
                $("#patient_group").val(response[0].patient_group);
                $("#admission_date").val(response[0].admission_date);
            }, error: function (response) {
                console.log(response);
            }
        });
    });
});