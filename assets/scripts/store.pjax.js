var pjax = new Pjax({
    elements: [".mz-menu a, .mlink, .breadcrumb a, .pagination a"],
    cacheBust: false,
    history: false,
    debug: false,
    currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
	selectors: ["title",".css-majax", ".js-majax", ".ajax-content",".box-users","#navigation"],
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
	$('.tooltip').remove();
};


function initEnd() {
	var pathname = window.location.pathname;

	if(pathname == '/events/all-events'){
		var location = pathname;
	} else {
		var location = pathname.slice(0, -2)
	}

	if(pathname == '/events-search'){
		var location = pathname;
	} else {
		var location = pathname.substring(0, 14);
	}

	if(pathname == '/events-groups'){
		var location = pathname;
	} else {
		var location = pathname.substring(0, 14);
	}

	if(pathname == '/events-type'){
		var location = pathname;
	} else {
		var location = pathname.substring(0, 13);
	}

	if(pathname == '/events/all-events'){
		var location = pathname;
	} else {
		var location = pathname.substring(0, 18);
	}
	
	if(location == '/events/all-events') {
		$('html, body').animate({
			scrollTop: $('.ajax-content').offset().top
		}, 'swing');
	}

	if(location == '/events-search') {
		$('html, body').animate({
			scrollTop: $('.section').offset().top
		}, 'swing');
	}

	if(location == '/events-groups') {
		$('html, body').animate({
			scrollTop: $('.section').offset().top
		}, 'swing');
	}

	if(location == '/events-type') {
		$('html, body').animate({
			scrollTop: $('.section').offset().top
		}, 'swing');
	}

	if(location == '/events/all-events') {
		$('html, body').animate({
			scrollTop: $('.section').offset().top
		}, 'swing');
	}

	// console.log(pathname);

};


document.addEventListener("pjax:send", initStart);
document.addEventListener("pjax:complete", initEnd);


// Form submit
function showResponse(data) {

	// remove loading ui block
	$('.overlay-search').unblock(); 
	
	// pjax load page
	pjax.options.requestOptions = {}
	pjax.loadUrl(data.url, $.extend({}, pjax.options))
}

function showRequest() {
	$('.overlay-search').block({
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
