(function ($) {

    var pjaxCart = new Pjax({
        elements: [".mlink"],
        cacheBust: false,
        history: true,
        debug: false,
        currentUrlFullReload: false, //jika di klik lagi link yg sama maka akan melakukan reload
        selectors: [".ajax-content", ".js-majax",".cart-btn"],
        switches: {
              ".ajax-content": Pjax.switches.outerHTML
        }
    })

    

    var base_url        = window.location.origin;

    var getcsrf  = function(name){
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    };

    function update_cart(rowid, qty){
        $.ajax({
            url : base_url + '/events-update-cart',
            method : "POST",
            data : {rowid: rowid, 'mz_token': getcsrf("mz_cookie"), qty: qty},
            async : true,
            dataType : 'json',
            success: function(data){

                if(data.limit_stock){

                    $('#qty-'+data.rowid).val(data.qty)

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    Toast.fire({
                        type: 'error',
                        title: data.message
                    })

                    return false;
                }

                if(data.status == 'success'){
                    $('#cart-btn-count').text(data.count);
                    $('#label_count').text(data.count);
                    if(data.used_voucher){
                        $('.price-voucher').html(data.price_voucher);
                        $('.price-sub-voucher').html(data.sub_voucher);
                    } else {
                        $('.apply-coupon').show();
                    }

                    if(data.rowid_voucher != 0){
                        $('#event-'+data.rowid_voucher).remove();
                        $('.apply-coupon').show();
                        //sweetalert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        
                        Toast.fire({
                            type: 'error',
                            title: data.message
                        })
                    }

                    if(data.used_flexi){
                        //sweetalert

                        if(data.can_use_flexi_if_has_used == true){
                            $('#flexi-'+data.rowid).addClass('del-text text-muted');
                            $('#flexi_used-'+data.rowid).text(data.flexi_user_message)
                        } else {

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            
                            Toast.fire({
                                type: data.status_flexi,
                                title: data.flexi_user_message
                            })
                        
                            
                        }

                        
                        $('#qty-'+data.rowid).val(data.qty_flexi)
                    }

                    if(data.can_use_flexi_if_has_used == false){
                        $('#flexi-'+data.rowid).removeClass('del-text text-muted')
                        $('#flexi_used-'+data.rowid).text('')
                    }
                    

                    if(data.subtotal.type ==  1){
                        var html = "<del class='text-muted'>"+ data.subtotal.old_subtotal +"</del><span class='text-danger'> (- "+ data.subtotal.discount +"%)</span><br>"+ data.subtotal.subtotal;
                    } else if(data.subtotal.type ==  2){
                        var html = "<del class='text-muted'>"+ data.subtotal.old_subtotal +"</del><span class='text-danger'> (- "+ data.subtotal.discount +")</span><br>"+ data.subtotal.subtotal;
                    } else {
                        var html = data.subtotal.subtotal;
                    }
                    
                    $('#'+data.rowid).html(html);
                    $('#total-cart').html(data.total);
                    
                    
                } else {
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
                    
                   pjaxCart.options.requestOptions = {}
                   pjaxCart.loadUrl(data.url, $.extend({}, pjaxCart.options))

                }
               
                
            }

        });
        
    }

    $('.plus').click(function (e) {
        if ($(this).prev().val() < 999) {
            $(this).prev().val(+$(this).prev().val() + 1);
            var rowid = $(this).data('id'); 
            update_cart(rowid, $(this).prev().val())
            
        }
        e.stopImmediatePropagation();
        return false;
    });
    $('.minus').click(function (e) {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
            var rowid = $(this).data('id'); 
            update_cart(rowid, $(this).next().val())
        }
        e.stopImmediatePropagation();
        return false;
    });


    $('.remove-product').click(function (e) {
        var rowid = $(this).data('id')
        $.ajax({
            url : base_url + '/events-remove-cart',
            method : "POST",
            data : {rowid: rowid, 'mz_token': getcsrf("mz_cookie")},
            async : true,
            dataType : 'json',
            success: function(data){

                if(data.status_cart == 0){
                    pjaxCart.options.requestOptions = {}
                    pjaxCart.loadUrl(base_url + '/events-cart', $.extend({}, pjaxCart.options))
                    return;
                }

                if(data.status == 'success'){
                    $('#event-'+rowid).remove();
                    $('#total-cart').html(data.total);
                    $('#cart-btn-count').text(data.count);
                    $('#label_count').text(data.count);

                    if(data.count == 0){
                        pjaxCart.options.requestOptions = {}
                        pjaxCart.loadUrl(base_url + '/events-cart', $.extend({}, pjaxCart.options))
                    }

                    if(data.used_voucher == false){
                        $('.apply-coupon').show();
                    }

                    if(data.rowid_voucher != 0){
                        $('#event-'+data.rowid_voucher).remove();
                        $('.apply-coupon').show();
                        //sweetalert
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        
                        Toast.fire({
                            type: 'error',
                            title: data.message
                        })
                    }

                    
       
                } else {
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
                    
                    pjaxCart.options.requestOptions = {}
                    pjaxCart.loadUrl(data.url, $.extend({}, pjaxCart.options))

                }
                
            }

        });
        e.stopImmediatePropagation();
        return false;
    });

    $('.apply-coupon').click(function (e) {
        Swal.fire({
            title: 'Insert Coupon or Voucher',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            showCloseButton: true,
            allowOutsideClick: false,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Apply',
            showLoaderOnConfirm: true,
            reverseButtons: true,
            confirmButtonColor: "#6cc47a",
            cancelButtonColor: '#e43f52',
            preConfirm: (voucher) => {
              if(voucher == ''){
                    Swal.showValidationMessage(
                        'Silahakan masukan kode voucher terlebih dahulu.'
                      )
                } else {
                    $.ajax({
                        url : base_url + '/events-apply-voucher',
                        method : "POST",
                        data : {code_voucher: voucher, 'mz_token': getcsrf("mz_cookie")},
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
                            
                            pjaxCart.options.requestOptions = {}
                            pjaxCart.loadUrl(base_url + '/events-cart', $.extend({}, pjaxCart.options))
                        }
                    })
                }
            },
          
          })
          e.stopImmediatePropagation();
            return false;
    });

})(window.jQuery); 