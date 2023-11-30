$(".approved").on("click", function () {
    $(this).val();
    $.ajax({
        type: "post",
        url: "/api/admin/approval",
        data: {approved_id: $(this).val()},
        success: function (response) {
            location.reload();
            console.log("success");
        }
    });
});

$(".denied").on("click", function () {
    $(this).val();
    $.ajax({
        type: "post",
        url: "/api/admin/approval",
        data: {denied_id: $(this).val()},
        success: function (response) {
            location.reload();
            console.log("success");
        }
    });
});