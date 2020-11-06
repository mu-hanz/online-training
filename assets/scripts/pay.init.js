// Form submit Auth

var base_url = window.location.origin;

var getcsrf  = function(name){
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : null;
};

function showRequestCheckout() {
	$.blockUI({
		message: '<div id="preloader"><div id="status"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div><h3 class="text-light">Sedang diproses...</h3></div></div>',
		overlayCSS: {
			backgroundColor: "#000",
			cursor: 'wait',
		},
		css: {
			border: 0,
			padding: 0,
			backgroundColor: 'none',
		},
		baseZ: 10000, 
	});
}



$(document).on('click', '.payAjax', function(e) {
	e.preventDefault(); // prevent native submit
	var id = $(this).data('id');
	
	showRequestCheckout();
	
	$.ajax({
		type: 'POST',
		url : base_url + '/events-checkout/snap-payment',
		data: {id : id, mz_token: getcsrf("mz_cookie")},
		dataType: 'json',
		success: function(data){

			snap.pay(data.token, {
				onSuccess: function(result){
					// console.log('success');console.log(result);
					$.ajax({
						type: 'POST',
						url : base_url + '/events-checkout/snap-onpayment',
						data: {result_data : JSON.stringify(result), mz_token: getcsrf("mz_cookie")},
						dataType: 'json',
						success: function(data){
							setTimeout(() => window.location.href = '/users/dashboard/order', 500)
						}
					})
				},
				onPending: function(result){
					// console.log('pending');console.log(result);
					
					$.ajax({
						type: 'POST',
						url : base_url + '/events-checkout/snap-onpayment',
						data: {result_data : JSON.stringify(result), mz_token: getcsrf("mz_cookie")},
						dataType: 'json',
						success: function(data){
							setTimeout(() => window.location.href = '/users/dashboard/order', 500)
						}
					})
					
				
				},
				onError: function(result){
					$.unblockUI();
					const Toast = Swal.mixin({
						toast: true,
						position: 'center',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						target: document.getElementById('popEl'),
					});
					
					Toast.fire({
						type: 'error',
						title: 'Sistem pembayaran sedang mengalami kendala!',
					})
				},
				onClose: function(){
					setTimeout(() => window.location.href = '/users/dashboard/order', 100)
				}
			})
		}
	})

	e.stopImmediatePropagation();
    return false;
});

	
