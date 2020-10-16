var base_url        = window.location.origin;
var csrfName        = $("#csrftoken").attr("name");
var csrfHash        = $('#csrftoken').val();
var redirect_sweetalert = $('#redirect_sweetalert').val();
const btn_text_delete = "Delete it!";
const btn_text_cencel = "Cancel";
const warning_text = "You will not be able to recover this!";
const warning_text_title = "Are you sure?";

$('#datatable-responsive').DataTable( {
    responsive: true
} );

$(document).on('click', '.del', function(e) {

    var term_id     = $(this).attr("term_id");
    var term_url    = $(this).attr("term_url");
    
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
            
            $.ajax({
                url: base_url + '/' + term_url,
                type: 'POST',
                data: {
                    'term_id': term_id,
                    [csrfName]:csrfHash
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

                    setTimeout(() => window.location.href = redirect_sweetalert, 2000)
                }
            });
        } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
        ) {
    
        }
    })
});