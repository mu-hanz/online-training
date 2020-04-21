var pjax = new Pjax({
    elements: [".mz-menu a, .mlink, .breadcrumb a"],
    cacheBust: false,
    history: true,
    debug: false,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
    selectors: ["[js-majax]", "#ajax-content"],
    switches: {
        "#ajax-content": Pjax.switches.outerHTML
    }
})

// Loading Page
function loadingPage() {
	$('.content-page').block({
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
	$('[css-majax]').remove();
	loadingPage();
};

function initEnd() {
	$('[css-majax]').appendTo(document.head);
	$('.content-page').unblock(); 
};

window.onload = function() {
    $('[css-majax]').appendTo(document.head);
};


document.addEventListener("pjax:send", initStart);
document.addEventListener("pjax:complete", initEnd);

// Form submit
function showResponse(data) {
    
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

	pjax.options.requestOptions = {}
	pjax.loadUrl(data.url, $.extend({}, pjax.options))
}

function showRequest() {

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
	loadingPage();
	$(this).ajaxSubmit(options);
	return false;
});




