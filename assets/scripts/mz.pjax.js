var pjax = new Pjax({
    elements: [".mz-menu a, .mlink, .breadcrumb a"],
    cacheBust: false,
    history: true,
    debug: true,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
    selectors: ["#footer", "#ajax-content"],
    switches: {
        "#ajax-content": Pjax.switches.sideBySide
    },
    switchesOptions: {
        "#ajax-content": {
            classNames: {
                // class added to the old element being replaced, e.g. a fade out
				remove: "Animated Animate--fast Animate--noDelay",
				// class added to the new element that is replacing the old one, e.g. a fade in
				add: "Animated",
				// class added on the element when navigating back
				backward: "fadeIn",
				// class added on the element when navigating forward (used for new page too)
				forward: "fadeOut"
            },
            callbacks: {
				
            }
        }
    }
})


function initStart() {
	$('[css-majax]').remove();
	$('.content-page').block({
		message: '<div class="spinner-border text-primary m-2" role="status"><span class="sr-only">Loading...</span></div>',
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

function initDone() {

}

function initEnd() {
	$('[css-majax]').appendTo(document.head);
	$('.content-page').unblock(); 
}

window.onload = function() {
    $('[css-majax]').appendTo(document.head);
};


document.addEventListener("pjax:send", initStart)
document.addEventListener("pjax:success", initDone)
document.addEventListener("pjax:complete", initEnd)

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
	$(this).ajaxSubmit(options);
	return false;
});




