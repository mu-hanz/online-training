$(document).ready(function() {

    // All Variable //
    var base_url                    = window.location.origin;
    var folder                      = $('#folder').val();
    var file                        = $('#file').val();
    var id_data                     = $('#id_data').val();
    var rows_selected               = [];
    var page                        = $('#page').val();
    var csrfName                    = $("#csrftoken").attr("name");
    var csrfHash                    = $('#csrftoken').val();
    var count_data_training         = $('#count_data_training').val();
    var valid_on                    = $("select[name=valid_on]").val();
    var beforelimit_user_referral   = $("input[name=limit_user_referral]").val();
    var max_fields                  = $("#max_field_tiers").val(); 
	var wrapper   		            = $(".container-tier");
    var x                           = $("#count_data_promotions_tier").val();
    // End All Variable //
 
    // Form Wizard //
    var navListItems = $('ul.setup-panel li a'),
    allWells = $('.setup-content');
    allWells.hide();
    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this).closest('li');
        
        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            allWells.hide();
            $target.show();
        }
    });
    $('ul.setup-panel li.active a').trigger('click');
    $(document).on('click', '#activate-step-2', function(e) {
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-2"]').trigger('click');
        return false;
    })    
    $(document).on('click', '#back-step-1', function(e) {
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-1"]').trigger('click');
        return false;
    })    
    // End Form Wizard //

    // Datepicker & Touchspin //
    ! function(o) {
        "use strict";
        function t() {}
        t.prototype.initFlatpickr = function() {
            o("#basic-datepicker").flatpickr(), o("#datetime-datepicker").flatpickr({
                enableTime: !0,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            }), o("#datetime-datepicker2").flatpickr({
                enableTime: !0,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            }), o("#range-datepicker").flatpickr({
                mode: "range"
            })
        },
        t.prototype.initTouchspin = function() {
            var a = {};
            o('[data-toggle="touchspin"]').each(function(t, i) {
                var e = o.extend({}, a, o(i).data());
                o(i).TouchSpin(e)
            })
        },
        t.prototype.init = function() {
            this.initFlatpickr(), this.initTouchspin()
        }, o.Components = new t, o.Components.Constructor = t
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.Components.init()
    }();
    // End Datepicker & Touchspin //

    // Amount Discount For Next Referral //
    if (page == 'create') {
        // $("#field_amount_discount_referral").hide();
        $("#field_amount_discount_referral").show();
    } else {
        $("#field_amount_discount_referral").show();
    }
    $("select[name=type_discount_referral]").change(function(){
        var type_discount = $(this).children("option:selected").val();
        if (type_discount == 'Flat' || type_discount == 'Accumulation') {
            $("#field_amount_discount_referral").show();
            $("#number-referral").hide();
            $(".additional-field-referral").remove();
        } else if (type_discount == 'Custom') {
            $("#field_amount_discount_referral").show();
            $("#number-referral").show();
            var limit_user_referral     = $("input[name=limit_user_referral]").val();
            var wrapperx   		        = $(".container-discount-referral");
            var count_referral          = $("input[name=count_data_promotions_type_referral]").val();
            if (page == 'create') {
                var xx                  = '2';
                for (xix = xx; xix <= limit_user_referral; xix++) {
                    $(wrapperx).append('<div class="form-group col-md-6 additional-field-referral"><label for="promotionName">Amount Discount For Next User Referral <span id="number-referral">'+ xix +'</span></label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control" id="inlineFormInputGroupxx' + xix + '" name="amount_discount_referral[]"></div></div>');
    
                    $(document).on('keyup', '#inlineFormInputGroupxx'+xix, function(e){
                        if(event.which >= 37 && event.which <= 40) return;
                        $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                        });
                    });
                }
            } else {
                var xx = 1;
                for (xix = xx; xix <= count_referral; xix++) {
                    $("#divreferral_" + xix).remove();
                }
                for (xix = xx; xix <= limit_user_referral; xix++) {
                    $(wrapperx).append('<div class="form-group col-md-6 additional-field-referral" id="divreferral_'+ xix +'"><label for="promotionName">Amount Discount For Next User Referral <span id="number-referral">'+ xix +'</span></label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control" id="inlineFormInputGroupxx' + xix + '" name="amount_discount_referral[]"></div></div>');
    
                    $(document).on('keyup', '#inlineFormInputGroupxx'+xix, function(e){
                        if(event.which >= 37 && event.which <= 40) return;
                        $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                        });
                    });
                }
                
            }
        } else {
            $("#field_amount_discount_referral").hide();
            $("#number-referral").hide();
            $(".additional-field-referral").remove();
        }
    });
    
    $('input[name=limit_user_referral]').on('keyup', function() {
        $(".additional-field-referral").remove();
        var data = $('select[name=type_discount_referral]').find('option:selected').val();
        if (data == 'Custom') {
            var limit_user_referral     = $("input[name=limit_user_referral]").val();
            var wrapperx   		        = $(".container-discount-referral");
            var count_referral          = $("input[name=count_data_promotions_type_referral]").val();
            if (page == 'create') {
                var xx                  = '2';
                for (xix = xx; xix <= limit_user_referral; xix++) {
                    $(wrapperx).append('<div class="form-group col-md-6 additional-field-referral"><label for="promotionName">Amount Discount For Next User Referral <span id="number-referral">'+ xix +'</span></label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control" id="inlineFormInputGroupxx' + xix + '" name="amount_discount_referral[]"></div></div>');
    
                    $(document).on('keyup', '#inlineFormInputGroupxx'+xix, function(e){
                        if(event.which >= 37 && event.which <= 40) return;
                        $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                        });
                    });
                }
            } else {
                var xx = 1;
                for (xix = xx; xix <= count_referral; xix++) {
                    $("#divreferral_" + xix).remove();
                }
                for (xix = xx; xix <= limit_user_referral; xix++) {
                    $(wrapperx).append('<div class="form-group col-md-6 additional-field-referral" id="divreferral_'+ xix +'"><label for="promotionName">Amount Discount For Next User Referral <span id="number-referral">'+ xix +'</span></label><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control" id="inlineFormInputGroupxx' + xix + '" name="amount_discount_referral[]"></div></div>');
    
                    $(document).on('keyup', '#inlineFormInputGroupxx'+xix, function(e){
                        if(event.which >= 37 && event.which <= 40) return;
                        $(this).val(function(index, value) {
                            return value
                            .replace(/\D/g, "")
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            ;
                        });
                    });
                }
                
            }
        }
    });
    $("#inlineFormInputGroupxx1").keyup(function(e){
        if(event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
        });
    });
    // End Amount Discount For Next Referral //

    

    // Add Delete Tier & Format Number
    $("#inlineFormInputGroup").keyup(function(e){
        if(event.which >= 37 && event.which <= 40) return;
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
        });
    });
    for (xi = 1; xi <= max_fields; xi++) {
        $(document).on('keyup', '#inlineFormInputGroup'+xi, function(e){
            if(event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
    
        $(document).on('keyup', '#inlineFormInputGroupx'+xi, function(e){
            if(event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
    }
    for (xi = 1; xi <= max_fields; xi++) {
        $(document).on('click', '.customRadio'+ xi, xi, function(e) {
            var xix = e.data;
            $( ".criteria_price"+ xix ).val('');
            $( ".criteria_qty"+ xix ).val('');
            var val_radio = $("input[type='radio'].customRadio"+ xix +":checked").val();
            if(val_radio == 'criteria_qty'){
                $( ".criteria_price"+ xix ).prop( "disabled", true ); 
                $( ".criteria_qty"+ xix ).prop( "disabled", false );
            }
            else {
                $( ".criteria_price"+ xix ).prop( "disabled", false );
                $( ".criteria_qty"+ xix ).prop( "disabled", true );
            }
        });
        $(document).on('click', '.customRadiox'+ xi, xi, function(e) {
            var xix = e.data;
            $( ".discount_percent"+ xix ).val('');
            $( ".discount_price"+ xix ).val('');
            var val_radio = $("input[type='radio'].customRadiox"+ xix +":checked").val();
            if(val_radio == 'discount_percent'){
                $( ".discount_price"+ xix ).prop( "disabled", true ); 
                $( ".discount_percent"+ xix ).prop( "disabled", false );
            }
            else {
                $( ".discount_price"+ xix ).prop( "disabled", false ); 
                $( ".discount_percent"+ xix ).prop( "disabled", true );
            }  
        });
    }
    $(document).on('click', '#button-add-tier', function(e){
		e.preventDefault();
		if(x < max_fields){
			x++;
			$(wrapper).append('<div class="form-group col-md-12 element-tier" id="div_'+ x +'"><div class="card card-promotion-tiers-custom"><div class="header-card-promotion-tiers-custom"><div class="float-right container-button-add-tier"></div><div class="float-left mb-3"><span class="mb-4">Tier '+ x +' <input type="hidden" name="name_tier'+ x +'" value="Tier '+ x +'"></span></div><div class="clearfix">&nbsp;</div></div><div class="card-body pt-2 pb-3"><div class="row"><div class="form-group col-md-12 mb-0"><label for="promotionName">Promotion Criteria</label><p class="sub-header mb-2">Diskon dapat diakumulasikan dalam 1 order (Misalnya dengan promosi "Beli 100.000 Diskon 30.000", jika membeli 300.000 maka potongan nya (300.000/100.000 x 30.000) = 90.000</p></div></div><div class="row"><div class="form-group col-md-6"><div class="custom-control custom-radio mb-2"><input type="radio" id="customRadio'+ x +'" name="customRadio'+ x +'" value="criteria_qty" class="customRadio'+ x +' custom-control-input"><label class="custom-control-label" for="customRadio'+ x +'">Amount Of Training >=</label></div><input type="text" class="form-control criteria_qty'+ x +'" name="criteria_qty'+ x +'" disabled></div><div class="form-group col-md-6"><div class="custom-control custom-radio mb-2"><input type="radio" id="customRadio'+ x +'_2" name="customRadio'+ x +'" value="criteria_price" class="customRadio'+ x +' custom-control-input"><label class="custom-control-label" for="customRadio'+ x +'_2">Transaction Value >=</label></div><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control criteria_price'+ x +'" id="inlineFormInputGroup'+ x +'" name="criteria_price'+ x +'" disabled></div></div></div><div class="row"><div class="form-group col-md-12 mb-0"><label for="promotionName">Discount</label><p class="sub-header mb-2">Diskon akan diberikan jika kriteria promosi tercapai</p></div></div><div class="row"><div class="form-group col-md-6 mb-0"><div class="custom-control custom-radio mb-2"><input type="radio" id="customRadiox'+ x +'" name="customRadiox'+ x +'" class="customRadiox'+ x +' custom-control-input" value="discount_percent"><label class="custom-control-label" for="customRadiox'+ x +'">Discount Percentage</label></div><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">% Off</div></div><input type="text" class="form-control discount_percent'+ x +'" name="discount_percent'+ x +'" id="inlineFormInputGroup" disabled></div></div><div class="form-group col-md-6 mb-0"><div class="custom-control custom-radio mb-2"><input type="radio" id="customRadiox'+ x +'_2" name="customRadiox'+ x +'" class="customRadiox'+ x +' custom-control-input" value="discount_price"><label class="custom-control-label" for="customRadiox'+ x +'_2">Discounts</label></div><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">IDR</div></div><input type="text" class="form-control discount_price'+ x +'" name="discount_price'+ x +'" id="inlineFormInputGroupx'+ x +'" disabled></div></div></div></div></div></div>');
		}
    });
    $(document).on('click', '.button-remove-tier', function(e){ 
		if (x != 1) {
            $("#div_" + x).remove();
            x = x - 1;
        }
    });
    // End Add Delete Tier & Format Number

    // Datatable
    // var base_url        = window.location.origin;
    // var csrfName        = $("#csrftoken").attr("name");
    // var csrfHash        = $('#csrftoken').val();
    // var folder          = $('#folder').val();
    // var file            = $('#file').val();
    // var id_data         = $('#id_data').val();
    // var rows_selected   = [];
    // var table = $('#basic-datatable').DataTable({
    //     "processing": true, 
    //     "serverSide": true, 
    //     "ajax":  
    //         {
    //             "url": base_url + '/webadmin/' + folder + '/' + file + '/get_data_json2/',
    //             "type": "POST",
    //             "data": {[csrfName]:csrfHash, page:page, id_data:id_data},
    //         },
    //     "orderData": [[ 1, 'asc' ]],
    //     "columns": [
    //         {
    //             "data": "event_id",
    //             'targets': 0,
    //             'className': 'dt-body-center',
    //             render: function (data, type, row, meta) {
    //                 if(row['checkbox'] == "1"){
    //                     if (valid_on == 'All Training') {
    //                         return '<input checked type="checkbox" disabled id="exampleCheck1" name="id[]" value="' + data + '">';
    //                     } else {
    //                         return '<input checked type="checkbox" id="exampleCheck1" name="id[]" value="' + data + '">';
    //                     }
    //                 }else{
    //                     return '<input type="checkbox" id="exampleCheck1" name="id[]" value="' + data + '">';
    //                 }
                    
    //             },
    //         },
    //         {
    //             "data": "post_title"
    //         },
    //         {
    //             "data": "event_cost"
    //         },
    //         {
    //             "data": "event_location"
    //         },
    //     ],
    //     'rowCallback': function(row, data, dataIndex){
    //         // Get row ID
    //         var rowId = data[0];
    //         // If row ID is in the list of selected row IDs
    //         if($.inArray(rowId, rows_selected) !== -1){
    //         $(row).find('input[type="checkbox"]').prop('checked', true);
    //         $(row).addClass('selected');
    //         }
    //     }
    // });

    var tablex = $('#basic-datatable').DataTable({
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center'
        },{
            'targets': 2,
            'orderable': false,
        }],
        'order': [[1, 'asc']]
    });

    // Checked And Disabled All Checkbox Datatable //
    var allPages                = tablex.cells( ).nodes( );
    $("select#custom-select1").change(function(){
        var valid_on = $(this).children("option:selected").val();
        if (valid_on == 'All Training') {
            $('input[type="checkbox"]', allPages).prop('checked', true);
            // $('input[type="checkbox"]', allPages).prop('readonly', true);
            $('.example-select-all').prop('checked', true);
            // $('.example-select-all').prop('disabled', true);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', false);
            // $('input[type="checkbox"]', allPages).prop('disabled', false);
            $('.example-select-all').prop('checked', false);
            // $('.example-select-all').prop('disabled', false);
        }
    });
    // End Checked And Disabled All Checkbox Datatable //  

    // Handle click on "Select all" control
    $('.example-select-all').on('click', function(){
        // Get all rows with search applied
        var rows = tablex.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#basic-datatable tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
        var el = $('.example-select-all').get(0);
        // If "Select all" control is checked and has 'indeterminate' property
        if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
        }
        }
    });
    // End Checked And Disabled All Checkbox Datatable //
    
    // Handle form submission event
    $('#form-ajax-datatable').on('submit', function(e){
        var form = this;

        // Encode a set of form elements from all pages as an array of names and values
        var params = tablex.$('input,select,textarea').serializeArray();

        // Iterate over all form elements
        $.each(params, function(){
            // If element doesn't exist in DOM
            if(!$.contains(document, form[this.name])){
                // Create a hidden element
                $(form).append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', this.name)
                    .val(this.value)
                );
            }
        });

        
    });
});

