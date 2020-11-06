(function ($) {

    var base_url        = window.location.origin;

    var getcsrf  = function(name){
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    };

$('#newssubscribebtn').click(function (e) {
    e.preventDefault();
    $('.mailchimp').block({
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
    
    var email = $('#emailchimp').val();
    $.ajax({
        url : base_url + '/mailchimp',
        method : "POST",
        data : {email: email, 'mz_token': getcsrf("mz_cookie")},
        async : true,
        dataType : 'json',
        success: function(data){
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
            $('.mailchimp').unblock(); 
            $('#emailchimp').val('');
        }

    });
});


})(window.jQuery); 