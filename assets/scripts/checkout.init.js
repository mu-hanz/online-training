// Form submit Auth

var base_url = window.location.origin;

var getcsrf  = function(name){
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : null;
};

function showResponseCheckout(data) {
	
	if(data.no_participant){
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
			type: data.status,
			title: data.message,
		})
		$('#place_order').attr("disabled", false);
		$('#mz-csrf-checkout').val(data.csrf_hash);
	} else {
		snap.pay(data.token, {
			onSuccess: function(result){
				// console.log('success');console.log(result);
				$.ajax({
					type: 'POST',
					url : base_url + '/events-checkout/snap-onpending',
					data: {result_data : JSON.stringify(result), mz_token: getcsrf("mz_cookie")},
					dataType: 'json',
					success: function(data){
						pjax.options.requestOptions = {}
						pjax.loadUrl(data.finish_redirect_url, $.extend({}, pjax.options))
					}
				})
			},
			onPending: function(result){
				// console.log('pending');console.log(result);

				$.ajax({
					type: 'POST',
					url : base_url + '/events-checkout/snap-onpending',
					data: {result_data : JSON.stringify(result), mz_token: getcsrf("mz_cookie")},
					dataType: 'json',
					success: function(data){
						pjax.options.requestOptions = {}
						pjax.loadUrl(data.finish_redirect_url, $.extend({}, pjax.options))
					}
				})
				
			
			},
			onError: function(result){
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
				$.unblockUI();
				$.blockUI({
					message: '<div id="preloader"><div id="status"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div><h3 class="text-light">Silahkan tunggu...</h3></div></div>',
					overlayCSS: {
						backgroundColor: "#000",
						cursor: 'wait',
					},
					css: {
						border: 0,
						padding: 0,
						backgroundColor: 'none'
					},
					baseZ: 10000, 
				});
				
				$.ajax({
					type: 'POST',
					url : base_url + '/events-checkout/snap-onpending',
					data: {status : 'onclose', order_id : data.order_id, date_transaction :  data.date_transaction, mz_token: getcsrf("mz_cookie")},
					dataType: 'json',
					success: function(data){
						pjax.options.requestOptions = {}
						pjax.loadUrl(base_url + '/users/dashboard', $.extend({}, pjax.options))
					}
				})
			}
		})
	}
      
}

function showRequestCheckout() {
	$.blockUI({
		message: '<div id="preloader"><div id="status"><div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div><h3 class="text-light">Transaksi sedang diproses...</h3></div></div>',
		overlayCSS: {
			backgroundColor: "#000",
			cursor: 'wait',
		},
		css: {
			border: 0,
			padding: 0,
			backgroundColor: 'none'
		},
		baseZ: 10000, 
	});
}

// ajax submit
var optionsAuthCheckout = {
	beforeSubmit:  showRequestCheckout,  // pre-submit callback
	success: showResponseCheckout, // post-submit callback 
	dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
	//clearForm: true,       // clear all form fields after successful submit 
	//resetForm: true        // reset the form after successful submit 
};

$(document).on('submit', '#ajaxFormCheckout', function(e) {
	e.preventDefault(); // prevent native submit
	$('#place_order').attr("disabled", "disabled");
	$(this).ajaxSubmit(optionsAuthCheckout);
	e.stopImmediatePropagation();
    return false;

});



function showResponseCheckoutUser(data) {
    
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

	if(data.status == 'success'){

		var id_event = $('#event-id-modal').val();
		var qty = $('#event-qty-modal').val();
		var user_data =  $("input[name='user_data-"+id_event+"[]']").length;
		$('#form-add-participan').unblock();

		$('#display-participant tr').remove();
		$('#add-new-participans').show();
		$('#table-peserta').show();
		$('#form-add-participan').hide();
		$('#back-participans').hide();
		$('#not-choose-'+id_event).hide();
		
		$('#ajaxFormCheckoutUser').clearForm();

		if(qty == user_data){
			get_particiapnts(id_event);
			return ;
		}

	 	add(data.id, data.name, id_event);
		get_particiapnts(id_event);
		 
		

	}

      
}

function showRequestCheckoutUser() {
	$('#form-add-participan').block({
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
var optionsAuthUser = {
	beforeSubmit:  showRequestCheckoutUser,  // pre-submit callback
	success: showResponseCheckoutUser, // post-submit callback 
	dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
	//clearForm: true,       // clear all form fields after successful submit 
	//resetForm: true        // reset the form after successful submit 
};

$(document).on('submit', '#ajaxFormCheckoutUser', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).ajaxSubmit(optionsAuthUser);
	e.stopImmediatePropagation();
    return false;
});


$('.add-participan-btn').on('click', function (e) {
	$('#add-participan').modal('toggle', $(this));
	var qty = $(this).attr('data-qty');
	$('#event-qty-modal').val(qty);
	var id = $(this).attr('data-id');
	$('#event-id-modal').val(id);
	e.stopImmediatePropagation();
    return false;
})

$('#add-participan').on('show.bs.modal', function (e) {
	
	var event_id = $(e.relatedTarget).data('id');
	get_particiapnts(event_id);
})

function get_particiapnts(event_id){
	var icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="color: #6dc77a;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>';

	var user_has_used = $("input[name='user_data-"+event_id+"[]']").map(function(){return $(this).val();}).get();
	
	$.ajax({
		url : base_url + '/events-get-participant',
		method : "POST",
		data : { 'mz_token': getcsrf("mz_cookie")},
		async : true,
		dataType : 'json',
		success: function(data){
			if(data.length == 0){
				tr = $('<tr/>');
				tr.append('<td colspan="2" class="text-center">Tidak ada data peserta silahkan klik tombol "Tambah"</td>');
				
				$('#display-participant').append(tr);
			}
			$.each(data, function(index, val) {

				if(jQuery.inArray(val.id_members, user_has_used) != -1) {
					var display_check = '';
					var display_choose = 'style="display:none"';
				} else {
					var display_check = 'style="display:none"';
					var display_choose = '';
				} 

				tr = $('<tr/>');
				tr.append('<td>' + val.name +' <span id="check-'+val.id_members+'-'+event_id+'" class="text-center" '+display_check+'>'+icon+'</span></td>');
				tr.append('<td><button type="button" class="btn btn-primary btn-sm choose-participant" data-name="'+ val.name +'" data-event="'+event_id+'" data-id="'+val.id_members+'" id="choose-'+val.id_members+'-'+event_id+'" '+display_choose+'>Pilih</button><button type="button" class="btn btn-danger btn-sm cancel-participant" '+display_check+' data-event="'+event_id+'" data-id="'+val.id_members+'" id="cancel-'+val.id_members+'-'+event_id+'">Batal</button></td>');
				$('#display-participant').append(tr);
			});
			
			
		}
	})
}

$(document).on('click', '.choose-participant', function(e) {
	var qty = $('#event-qty-modal').val();
	var id_member = $(this).attr('data-id');
	var id_event = $(this).attr('data-event');
	var name = $(this).attr('data-name');
	var user_data =  $("input[name='user_data-"+id_event+"[]']").length;
	$('#not-choose-'+id_event).hide();
	
	if(qty == user_data){
		return ;
	}

	$('#check-'+id_member+'-'+id_event).show();
	$(this).hide();
	$('#cancel-'+id_member+'-'+id_event).show();
	add(id_member, name, id_event);
	e.stopImmediatePropagation();
    return false;
})

$(document).on('click', '.cancel-participant', function(e) {
	var id_member = $(this).attr('data-id');
	var id_event = $(this).attr('data-event');
	$('#check-'+id_member+'-'+id_event).hide();
	$(this).hide();
	$('#choose-'+id_member+'-'+id_event).show();
	remove(id_member, id_event);
	var user_data =  $("input[name='user_data-"+id_event+"[]']").length;
	
	if(user_data == 0){
		$('#not-choose-'+id_event).show();
		
	}

	e.stopImmediatePropagation();
        return false;
})

function add(id, name, id_event){
	var html = '<div id="user-'+id+'-'+id_event+'" class="alert alert-outline-primary mr-3 alert-pills" role="alert">'+
				'<input type="hidden" name="user_data-'+id_event+'[]" value="'+id+'">'+
				'<span class="alert-content  mr-3"><strong>'+name+'</strong></span>'+
				'<a href="javascript:void(0);" class="badge badge-pill  btn btn-soft-danger remove-user" data-event="'+id_event+'" data-id="'+id+'"> x </a>'+
			'</div>';
			
	$('#box-peserta-'+id_event).append(html);
}

function remove(id, id_event){
	$('#user-'+id+'-'+id_event).remove();
	var user_data =  $("input[name='user_data-"+id_event+"[]']").length;
	
	if(user_data == 0){
		$('#not-choose-'+id_event).show();
	}
}


$(document).on('click', '.remove-user', function(e) {
	e.preventDefault();
	var id_member = $(this).attr('data-id');
	var id_event = $(this).attr('data-event');
	$('#user-'+id_member+'-'+id_event).remove();
	var user_data =  $("input[name='user_data-"+id_event+"[]']").length;
	
	if(user_data == 0){
		$('#not-choose-'+id_event).show();
	}
	e.stopImmediatePropagation();
    return false;
})


$(document).on('click', '#add-new-participans', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).hide();
	$('#table-peserta').hide();
	$('#back-participans').show();
	$('#form-add-participan').show();
	$("#s_participant").hide();
	// return false;
	e.stopImmediatePropagation();
    return false;
});

$(document).on('click', '#back-participans', function(e) {
	e.preventDefault(); // prevent native submit
	$(this).hide();
	$('#display-participant tr').remove();
	$('#add-new-participans').show();
	$('#table-peserta').show();
	$('#form-add-participan').hide();
	var event_id = $('#event-id-modal').val();
	$("#s_participant").show();
	get_particiapnts(event_id);
	e.stopImmediatePropagation();
    return false;
});

$('#add-participan').on('hidden.bs.modal', function (e) {
	$('#table-peserta').show();
	$('#form-add-participan').hide();
	$('#display-participant tr').remove();
	$('#back-participans').hide();
	$('#add-new-participans').show();
	e.stopImmediatePropagation();
    return false;
})

$(document).ready(function(){
	$("#s_participant").on("keyup", function() {
	  var value = $(this).val().toLowerCase();
	  $("#display-participant tr").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	  });
	});
  });


	
