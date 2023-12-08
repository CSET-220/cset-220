$(document).ready(function() {
    $("#patient_id").on("change", function () {
        $.ajax({
            type: "get",
            url: "/api/admin/patient/Info",
            data: {patient_id: $(this).val()},
            success: function (response) {
                console.log("success");
                $("#patient_name").val(response);
                }, error: function (response) {
                console.log("error");
            }
        });
    });
});