var pjax = new Pjax({
    elements: [".mz-menu a, .mlink, .breadcrumb a"],
    cacheBust: false,
    history: true,
    debug: false,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
	selectors: ["title",".css-majax", ".js-majax", ".ajax-content"],
	switches: {
		  ".ajax-content": Pjax.switches.outerHTML
    }
})

  


function initStart() {
	$('.blockui').block({ 
		overlayCSS: { backgroundColor: '#fff' },
		message: 'Tunggu sebentar...',
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
	return false;
});

