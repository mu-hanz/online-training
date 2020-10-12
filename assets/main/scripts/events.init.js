(function ($) {


var getcsrf  = function(name){
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
};


$(".enroll").click(function(){
    var id              = $(this).data('id'); 
    var url          = window.location.pathname;
    var base_url        = window.location.origin;

    // alert(id);
    $.ajax({
        url : base_url + '/events-add-cart',
        method : "POST",
        data : {id: id, 'mz_token': getcsrf("mz_cookie"), url: url},
        async : true,
        dataType : 'json',
        success: function(data){

            if(data.status == 'success'){

                pjax.options.requestOptions = {}
                pjax.loadUrl(base_url + '/events-cart', $.extend({}, pjax.options))

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000
                });
                
                Toast.fire({
                    type: 'danger',
                    title: data.message
                })
            }
                
                
                
        }
    });
    return false;
});



$(".add-to-cart").click(function(){
    var id              = $(this).data('id'); 
    var url          = window.location.pathname;
    var base_url        = window.location.origin;

    // alert(id);
    $.ajax({
        url : base_url + '/events-add-cart',
        method : "POST",
        data : {id: id, 'mz_token': getcsrf("mz_cookie"), url: url},
        async : true,
        dataType : 'json',
        success: function(data){

            if(data.status == 'success'){

                Swal.fire({
                    title: '<strong>Added To Cart</strong>',
                    type: 'success',
                    text: data.message,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    allowOutsideClick: false,
                    confirmButtonColor: "#6cc47a",
                    cancelButtonColor: '#5a6d90',
                    reverseButtons: true,
                    confirmButtonText:
                      '<i data-feather="shopping-cart" class="fea icon-md"></i> View Cart',
                    confirmButtonAriaLabel: 'View Cart',
                    cancelButtonText:
                      '<i data-feather="arrow-left" class="fea icon-md"></i> Continue Order',
                    cancelButtonAriaLabel: 'Continue Order'
                  }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.value) {
                        // pjax load page
                        pjax.options.requestOptions = {}
                        pjax.loadUrl(base_url + '/events-cart', $.extend({}, pjax.options))
                    } else {
                        pjax.options.requestOptions = {}
                        pjax.loadUrl(base_url + '/' + url, $.extend({}, pjax.options))
                      
                    }
                  })

                  feather.replace()

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000
                });
                
                Toast.fire({
                    type: 'danger',
                    title: data.message
                })
            }
                
                
                
        }
    });
    return false;
});



})(window.jQuery); 