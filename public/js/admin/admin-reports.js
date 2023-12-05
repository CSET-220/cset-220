$(document).ready(function(){
    var table = $('#myTable').DataTable();
    var filter = $('#myTable_filter');
    filter.addClass("hidden");

    function clearCustomSearch() {
        $.fn.dataTable.ext.search.pop();
        table.draw();
    }

    function dateSearch(inputData) {
        clearCustomSearch();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var dateStr = data[1];
                var dateParts = dateStr.split("-");
                var date = new Date('20' + dateParts[2], dateParts[0] - 1, dateParts[1]);
                var inputParts = inputData.split("/");
                var selectedDate = new Date(inputParts[2], inputParts[0] - 1, inputParts[1]);
                return date.toDateString() === selectedDate.toDateString();
            }
        );
        table.draw();
    }
    $('#datePicker').on('changeDate', function() {
        var inputData = $(this).val();
        if(inputData) {
            dateSearch(inputData);
        } else {
            clearCustomSearch();
        }
    });
    $('#clear').on('click', function() {
        clearCustomSearch();
        $('#datePicker').val('');
    })
})