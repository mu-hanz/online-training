$(document).ready(function() {
    // datatable
    var base_url = window.location.origin;
    const btn_text_delete = "Delete it!";
    const btn_text_cencel = "Cancel";
    const warning_text = "You will not be able to recover this!";
    const warning_text_title = "Are you sure?";

    var csrf =  muhanz.getcsrf("mz_cookie");
    var table = $('#datatable-content').DataTable({
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
        "drawCallback": function(settings) {
            //refresh pjax
            var newContent = document.querySelector("#datatable-content");
            pjax.refresh(newContent);
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


    $(document).on('click', '.del', function(e) {
        e.preventDefault();
    
        var id = $(this).data("id");
        
        Swal.fire({
          title: warning_text_title,
          text: warning_text,
          type: 'warning',
          width: '350px',
          showCancelButton: true,
          confirmButtonText: btn_text_delete,
          cancelButtonText: btn_text_cencel,
          reverseButtons: false,
          confirmButtonColor: "#f44455",
          cancelButtonColor: '#5369f8',
          allowOutsideClick: false,
        }).then((result) => {
          if (result.value) {
            var csrf =  muhanz.getcsrf("mz_cookie");
              $.ajax({
                  url: base_url + '/webadmin/posts/events/delete_content/' + id,
                  type: 'POST',
                  data: {
                      'mz_token': csrf
                  },
                  dataType: 'json',
                  success: function(data) {
    
                      const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2500
                      });
                      
                      Toast.fire({
                        type: data.status,
                        title: data.message
                      })
    
                      pjaxS.options.requestOptions = {}
                      pjaxS.loadUrl(data.url, $.extend({}, pjaxS.options))
                  }
              });
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {
            
          }
        })
    
    });

});