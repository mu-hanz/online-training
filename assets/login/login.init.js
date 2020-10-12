// Form submit
function showResponse(data) {
    
	const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
		timer: 2000,
		timerProgressBar: true,
		target: document.getElementById('popEl'),
      });
      
      Toast.fire({
        type: data.status,
		title: data.message,
      })
    
    if(data.status == 'error'){
        $('#mz-csrf').val(data.csrf_hash);
        $('.form-body').unblock();
    } else {

		setTimeout(() => window.location.href = '/users/dashboard', 2000)
		

    }
      
}

function showRequest() {
	$('.form-body').block({
		message: '<i class="fas fa-circle-notch fa-spin"></i>',
		overlayCSS: {
			backgroundColor: "#fff",
			cursor: 'wait',
		},
		css: {
			border: 0,
			padding: 0,
			backgroundColor: 'none'
		}
	});
}

// ajax submit
var options = {
	beforeSubmit:  showRequest,  // pre-submit callback
	success: showResponse, // post-submit callback 
	dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
	//clearForm: true,       // clear all form fields after successful submit 
	//resetForm: true        // reset the form after successful submit 
};

$(document).on('submit', '.ajaxFormAuth', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).ajaxSubmit(options);
	return false;
});

$(document).on('click', '.goback', function(e) {
	e.preventDefault(); // prevent native submit
	window.history.back();
});
