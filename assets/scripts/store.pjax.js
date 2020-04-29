var pjax = new Pjax({
    elements: [".mz-menu a, .mlink, .breadcrumb a"],
    cacheBust: false,
    history: false,
    debug: false,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
	selectors: ["title",".css-majax", ".js-majax", ".ajax-content"],
	switches: {
		  ".ajax-content": Pjax.switches.outerHTML
    }
})

  
// Loading Block init
function loadingPage() {
	$.blockUI({
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

function initStart() {
	Pace.start();
};

function initEnd() {
	Pace.stop();
};



document.addEventListener("pjax:send", initStart);
document.addEventListener("pjax:complete", initEnd);

// Form submit
function showResponse(data) {

	// remove loading ui block
	$.unblockUI();
	
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
	loadingPage();
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
