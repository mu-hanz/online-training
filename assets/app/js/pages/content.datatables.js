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
            "url": base_url + '/webadmin/posts/events/json_content',
            "type": "POST",
            "data": {
                'mz_token': csrf
            }
        },
        "initComplete": function(settings, json) {
            table.ajax.reload();
        },
        "columnDefs": [{ 
            width: 400, 
            targets: 0
        },{ 
            width: 100, 
            targets: 1 
        },{ 
            targets: 2 ,
            render: function ( data, type, row ) {
                return data + '<br> By. ' + row.author_name;
            },
        },{ 
            targets: 3 ,
            render: function ( data, type, row ) {
                if(row.author_name_edit == null){
                    return data ;
                } else {
                    return data + '<br> By. ' + row.author_name_edit;
                }
               
            },
        },{ 
            width: 80, 
            targets: 4 
        } ],
        "columns": [{
            "data": "post_title",
            'className': 'align-middle'
        }, {
            "data": "post_status",
            'className': 'align-middle text-center'
        }, {
            "data": "post_date",
            'className': 'align-middle text-center'
        }, {
            "data": "post_modifed",
            'className': 'align-middle text-center'
        }, {
            "data": "action",
            'orderable': false,
            'className': 'text-center'
        }],
    });




});