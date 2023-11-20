$(document).ready(function(){
    var table = $('#myTable').DataTable();

    function clearCustomSearch() {
        $.fn.dataTable.ext.search.pop();
    }

    function defaultSearch() {
        clearCustomSearch();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var today = new Date();
                var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                var dateStr = data[0];
                var dateParts = dateStr.split("-");
                var date = new Date(dateParts[2], dateParts[0] - 1, dateParts[1]);

                return date >= minDate;
            }
        );
        table.draw();
    }

    function dateSearch(inputData) {
        clearCustomSearch();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var dateStr = data[0];
                var dateParts = dateStr.split("-");
                var date = new Date(dateParts[2], dateParts[0] - 1, dateParts[1]);
                var selectedDate = new Date(inputData);
                return date.toDateString() === selectedDate.toDateString();
            }
        );
        table.draw();
    }

    defaultSearch();

    $('#datePicker').on('changeDate', function() {
        var inputData = $(this).val();
        if(inputData) {
            dateSearch(inputData);
        } else {
            defaultSearch();
        }
    });

    $('#clear').on('click', function() {
        defaultSearch();
        $('#datePicker').val('');
    })
});