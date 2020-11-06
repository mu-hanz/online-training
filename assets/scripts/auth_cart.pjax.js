$(document).on('click', '.google-sign-in', function(e) {
	e.preventDefault();
	var base_url = window.location.origin;
	var popupWinWidth = 500;
	var popupWinHeight = 600;
	var left = (screen.width - popupWinWidth) / 2; 
	var top = (screen.height - popupWinHeight) / 2; 
	
	var authWindow = window.open(base_url + '/socialconnect/auth/Google', 'Google Sign-in - Training Center',  
			'resizable=yes, width=' + popupWinWidth 
			+ ', height=' + popupWinHeight + ', top=' 
			+ top + ', left=' + left); 
	window.closeAuthWindow = function () {
		authWindow.close();
	}

});

// Form submit Auth
function showResponseAuth(data) {
    
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

		setTimeout(() => window.location.href = data.url, 2000)
		

    }
      
}

function showRequestAuth() {
	$('.form-body').block({
		message: '<div id="preloader"><div id="status"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div></div></div>',
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
var optionsAuth = {
	beforeSubmit:  showRequestAuth,  // pre-submit callback
	success: showResponseAuth, // post-submit callback 
	dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
	//clearForm: true,       // clear all form fields after successful submit 
	//resetForm: true        // reset the form after successful submit 
};

$(document).on('submit', '.ajaxFormAuth', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).ajaxSubmit(optionsAuth);
	return false;
});

