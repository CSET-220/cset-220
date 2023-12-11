$(document).ready( () => {
    $.fn.dataTable.ext.type.order['date-mmddyyyy-pre'] = function (dateStr) {
        if (!dateStr) {
            return 0;
        }
        var parts = dateStr.split('-');
        var date = new Date(parts[2], parts[0] - 1, parts[1]);
        return date.getTime();
    };

    const myTable = $('#myTable').DataTable({
        dom: 'lBfrtip',
        buttons: [{
            extend: 'pdf',
            text: 'Download Logs',
            filename: `${filename}`,
            title: 'Daily Logs',
            customize: function (doc) {
                doc.defaultStyle.alignment = 'center';
            },
        }],
        columnDefs: [
            {className: "dt-center", "targets": "_all"},
            {type: "date-mmddyyyy", targets: 0},
        ],
    });

    function dateSearch(inputData) {
        $.fn.dataTable.ext.search.pop();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var dateStr = data[0];
                var dateParts = dateStr.split("-");
                var date = new Date(dateParts[2], dateParts[0] - 1, dateParts[1]);
                var selectedDate = new Date(inputData);
                return date.toDateString() === selectedDate.toDateString();
            }
        );
        myTable.draw();
    }

    $('#datePicker').on('changeDate', function() {
        var inputData = $(this).val();
        if(inputData) {
            dateSearch(inputData);
        }  else {
            clearCustomSearch();
        }
    });

    $('#clear').on('click', function() {
        $.fn.dataTable.ext.search.pop();
        $('#datePicker').val('');
        myTable.draw();
    })
})