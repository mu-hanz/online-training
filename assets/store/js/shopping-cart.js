$(document).ready(function(){

    var base_url        = window.location.origin;
    var csrfName        = $("#csrftoken").attr("name");
    var csrfHash        = $('#csrftoken').val();
    
    function subTotalFunction () {
        var sub_total = 0;
        $('.input_price_event').each(function() {
            sub_total += parseInt($(this).val());
        });
        $("#id_sub-total-shopping-cart").val(sub_total);
        var sub_total = 'Rp. '+(sub_total/1000).toFixed(3)+',-';
        $("#sub-total-shopping-cart").text(sub_total);
    };

    subTotalFunction();

    $('.qty-sc').bind('keyup', function(){
        var id                          = $(this).attr('id'); 
        var qty                         = $(this).val();
        var category                    = 'UpdateShoppingCartDetail'; 
        var category2                   = 'UpdateDiscountCollectibleVoucher'; 
        var collectible_voucher         = $('#id-discount-collectible-voucher-shopping-cart').val();
        var first_collectible_voucher   = $('#first-discount-collectible-voucher-shopping-cart').val();
        
        $.ajax({
            url : base_url + '/shopping-cart/update',
            method : "POST",
            data : {id: id, [csrfName]:csrfHash, qty: qty, category: category, collectible_voucher: collectible_voucher},
            async : true,
            dataType : 'json',
            beforeSend: function(){
                $("#box-blur").addClass("box-cart-custom-blur");
                $("#loader-blur").addClass("loader-shopping-cart-custom");
            },
            success: function(data){
                $('#price_event'+id).html(data.price_event);
                var mystring = data.price_event.replace(/[^\d]/g,'');
                $('#input_price_event'+id).val(mystring);
                subTotalFunction();
                if (first_collectible_voucher != '0') {
                    var sub_total                   = $('#id_sub-total-shopping-cart').val();
                    var limit_collectible_voucher   = $('.discount-limit-collectible-voucher-shopping-cart').val();
                    if (parseInt(sub_total) < parseInt(limit_collectible_voucher)) {
                        $('#id-discount-collectible-voucher-shopping-cart').val('0');
                        $('.container-discount-collectible-voucher').hide();
                    } else {
                        $('#id-discount-collectible-voucher-shopping-cart').val(first_collectible_voucher);
                        $('.container-discount-collectible-voucher').show();
                    }
                } else {
                    var sub_total                   = $('#id_sub-total-shopping-cart').val();
                    var limit_collectible_voucher   = $('.discount-limit-collectible-voucher-shopping-cart').val();
                    var id_collectible_voucher      = $('#id_collectible_voucher').val();
                    if (parseInt(sub_total) < parseInt(limit_collectible_voucher)) {
                        $('#id-discount-collectible-voucher-shopping-cart').val('0');
                        $('.container-discount-collectible-voucher').hide();
                    } else {
                        $.ajax({
                            url : base_url + '/shopping-cart/update',
                            method : "POST",
                            data : {id: id, [csrfName]:csrfHash, qty: qty, category: category, collectible_voucher: collectible_voucher, category2: category2, id_collectible_voucher: id_collectible_voucher, sub_total: sub_total},
                            async : true,
                            dataType : 'json',
                            success: function(data){
                                var mystring = data.discount_collectible_voucher.replace(/[^\d]/g,'');
                                $('#id-discount-collectible-voucher-shopping-cart').val(mystring);
                                $('#first-discount-collectible-voucher-shopping-cart').val(mystring);
                                $('#discount-collectible-voucher-shopping-cart').text(data.discount_collectible_voucher);
                                $('.container-discount-collectible-voucher').show();
                            }
                        });  
                    }
                }
                $('#coupon_code').val('');
                $('#id-discount-voucher-shopping-cart').val('');
                $('.alert-voucher').hide();
                $('.container-discount-voucher').hide();
            },
            complete:function(data){
                $("#box-blur").removeClass("box-cart-custom-blur");
                $("#loader-blur").removeClass("loader-shopping-cart-custom");
            }
        });
        return false;
    });

    $(".cart-list").on("click", ".delete-row-shopping-cart", function() {
        var id                      = $(this).attr('id');
        var category                = 'DeleteShoppingCartDetail';
        var qty                     = '';
        var node                    = this;
        var id_shopping_cart        = $('#id_shopping_cart').val();
        var id_collectible_vucher   = $('#id_collectible_voucher').val();
        $.ajax({
            url : base_url + '/shopping-cart/update',
            method : "POST",
            data : {id: id, [csrfName]:csrfHash, qty: qty, category: category, id_shopping_cart: id_shopping_cart, id_collectible_vucher: id_collectible_vucher},
            async : true,
            dataType : 'json',
            beforeSend: function(){
                $("#box-blur").addClass("box-cart-custom-blur");
                $("#loader-blur").addClass("loader-shopping-cart-custom");
            },
            success: function(data){
                if (data.status_delete == 'Success') {
                    $(node).closest('tr').remove();
                    subTotalFunction();
                    $('#coupon_code').val('');
                    $('#id-discount-voucher-shopping-cart').val('');
                    $('.alert-voucher').hide();
                    $('.container-discount-voucher').hide();
                    // Collectible Voucher
                    if (data.status_collectible_voucher == 'Found') {
                        var sub_total                   = $('#id_sub-total-shopping-cart').val();
                        var limit_collectible_voucher   = $('.discount-limit-collectible-voucher-shopping-cart').val();
                        if (parseInt(sub_total) < parseInt(limit_collectible_voucher)) {
                            $('#id-discount-collectible-voucher-shopping-cart').val('0');
                            $('.container-discount-collectible-voucher').hide();
                        } else {
                            $('#id-discount-collectible-voucher-shopping-cart').val(first_collectible_voucher);
                            $('.container-discount-collectible-voucher').show();
                        }
                    }
                }
                if (data.count_shopping_cart == 'Empty') {
                    $('.cart-list').hide();
                    $('.cart-options').hide();
                    $('.cart-is-empty').show();
                    $("#sub-total-shopping-cart").text('Rp. 0,-');
                }
                if (data.status_voucher == 'Available') {
                    $('#status_voucher').val('Available');
                } else {
                    $('#status_voucher').val('Not Available');
                }
            },
            complete:function(data){
                $("#box-blur").removeClass("box-cart-custom-blur");
                $("#loader-blur").removeClass("loader-shopping-cart-custom");
            }
        });
        return false;
    });

    $("#check-coupon-code").click(function(){
        var id                  = '';
        var category            = 'CheckCouponCode';
        var qty                 = '';
        var coupon_code         = $('#coupon_code').val();
        var status_voucher      = $('#status_voucher').val();
        var id_shopping_cart    = $('#id_shopping_cart').val();
        var sub_total           = $('#id_sub-total-shopping-cart').val();
        if (status_voucher != 'Available') {
            $('.alert-voucher').text('Kode voucher tidak berlaku untuk keranjang belanja ini');
            $('.alert-voucher').show();
        } else {
            $.ajax({
                url : base_url + '/shopping-cart/update',
                method : "POST",
                data : {id: id, qty: qty, coupon_code: coupon_code, [csrfName]:csrfHash, id_shopping_cart: id_shopping_cart, category: category, sub_total: sub_total},
                async : true,
                dataType : 'json',
                beforeSend: function(){
                    $("#box-blur").addClass("box-cart-custom-blur");
                    $("#loader-blur").addClass("loader-shopping-cart-custom");
                },
                success: function(data){
                    if (data.status_voucher == 'Available') {
                        $('.container-discount-collectible-voucher').hide();
                        $('#id-discount-collectible-voucher-shopping-cart').val('0');
                        $('.alert-voucher').text('Diskon voucher berhasil ditambahkan');
                        $('.alert-voucher').show();
                        $('#discount-voucher-shopping-cart').text(data.nominal_discount_voucher);
                        $('#id-discount-voucher-shopping-cart').val(data.nominal_discount_voucher.replace(/[^\d]/g,''));
                        $('.container-discount-voucher').show();
                    } else if(data.status_voucher == 'Not Available') {
                        $('.alert-voucher').text('Voucher tidak tersedia / tidak berlaku');
                        $('.alert-voucher').show();
                        $('.container-discount-voucher').hide();
                    } else if (data.status_voucher == 'Limit Not Available') {
                        $('.alert-voucher').text('Batas pemakaian voucher sudah habis');
                        $('.alert-voucher').show();
                        $('.container-discount-voucher').hide();
                    } else if (data.status_voucher == 'Limit Nominal Not Available') {
                        $('.alert-voucher').text('Batas nominal keranjang belanja tidak memenuhi syarat');
                        $('.alert-voucher').show();
                        $('.container-discount-voucher').hide();
                    }
                },
                complete:function(data){
                    $("#box-blur").removeClass("box-cart-custom-blur");
                    $("#loader-blur").removeClass("loader-shopping-cart-custom");
                }
            });
        }
        return false;
    }); 

});