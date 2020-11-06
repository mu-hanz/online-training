var pjax = new Pjax({
    elements: [".mlink"],
    cacheBust: false,
    history: true,
    debug: false,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
	selectors: ["title","body"],
	switches: {
		  "body": Pjax.switches.outerHTML
    }
})

  


function initStart() {
	$('.blockui').block({ 
		overlayCSS: { backgroundColor: '#fff' },
		message: 'Please wait...',
		centerY: 0, 
		css: { 
			top: '20%',
            border: 'none', 
            padding: '1px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
			color: '#fff'
		}
	}); 
};

function initEnd() {
	$('.blockui').unblock({ fadeOut: 200 }); 
	
};



document.addEventListener("pjax:send", initStart);
document.addEventListener("pjax:complete", initEnd);

// Form submit
function showResponse(data) {
	
	//sweetalert
	const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 2000
      });
      
      Toast.fire({
        type: data.status,
        title: data.message
      })
	
	// pjax load page
	pjax.options.requestOptions = {}
	pjax.loadUrl(data.url, $.extend({}, pjax.options))
}

function showRequest() {
	//loading ui block
	// loadingPage();
}

// ajax form submit
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
	e.stopImmediatePropagation();
	return false;
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

		setTimeout(() => window.location.href = '/users/dashboard', 2000)
		

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
	e.stopImmediatePropagation();
	return false;
});
