// Form submit
function showResponse(data) {
	
	if(data.not_admin){
		setTimeout(() => window.location.href = data.url);
		return;
	}

	const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });
      
      Toast.fire({
        type: data.status,
        title: data.message
	  })
	
    
    if(data.status == 'error'){
        $('#mz-csrf').val(data.csrf_hash);
		$('.data-loading').unblock();
    } else {

		setTimeout(() => window.location.href = data.url, 2000)
		

    }
      
}

function showRequest() {
	$('.data-loading').block({
		message: '<div class="spinner-border text-primary m-2" role="status"></div>',
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

$(document).on('submit', '.ajaxForm', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).ajaxSubmit(options);
	return false;
});
