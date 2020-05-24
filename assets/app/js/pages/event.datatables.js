$(document).ready(function() {
    // datatable
    var base_url = window.location.origin;
    var csrf =  muhanz.getcsrf("mz_cookie");
    var table = $('#datatable-event').DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "autoWidth": false,
        "ajax": {
            "url": base_url + '/webadmin/posts/events/json_event',
            "type": "POST",
            "data": {
                'mz_token': csrf
            }
        },
        "drawCallback": function(settings) {
            //refresh pjax
            var newContent = document.querySelector(".data-list-view");
            pjax.refresh(newContent);
        },
        "initComplete": function(settings, json) {
            table.ajax.reload();
        },
        "columnDefs": [{ 
            width: 170, 
            targets: 0 
        },{ 
            width: 250, 
            targets: 2 
        },{ 
            width: 80, 
            targets: 3 
        } ],
        "columns": [{
            "data": "event_img",
            'orderable': false,
            'className': 'p-0',
        }, {
            "data": "detail_event",
            'name': "event_name",
            'orderable': false,
            'className': 'pt-1 pb-1'
        }, {
            "data": "event_date",
            'orderable': false,
            'className': 'pt-1 pb-1'
        }, {
            "data": "action",
            'orderable': false,
            'className': 'pt-1 pb-1 text-center'
        }, {
            "data": "event_name",
        }, {
            "data": "event_subtitle",
        }, {
            "data": "event_sku",
        }, {
            "data": "category",
        }, {
            "data": "type",
        }, {
            "data": "group",
        }, {
            "data": "certificate",
        }, {
            "data": "regional",
        }, {
            "data": "location",
        } ],
    });

    // for searchable
    table.column(4).visible(false);
    table.column(5).visible(false);
    table.column(6).visible(false);
    table.column(7).visible(false);
    table.column(8).visible(false);
    table.column(9).visible(false);
    table.column(10).visible(false);
    table.column(11).visible(false);
    table.column(12).visible(false);

    // $(table.table().body()).addClass('body-row');
    // if (type == 'pages') {
    //     table.column(3).visible(false);
    //     table.column(4).visible(false);
    //     table.columns.adjust().draw(false);
    // } else if (type == 'events') {
    //     table.column(4).visible(false);
    //     table.columns.adjust().draw(false);
    // } else {
    //     table.columns.adjust().draw(false);
    // }

});