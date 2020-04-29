$(document).ready(function() {
    $("#datatable").DataTable({

        ordering: false,
        autoWidth: false,
        initComplete: function () {
            $('.show-table').fadeIn();
        },
        columnDefs: [{
            orderable: false,
            targets: [0]
        }],
              
        language: {
            paginate: {
                previous: "<i class='uil uil-angle-left'>",
                next: "<i class='uil uil-angle-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});