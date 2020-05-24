$(document).ready(function() {

    // All Variable //
    var base_url            = window.location.origin;
    var csrfName            = $("#csrftoken").attr("name");
    var csrfHash            = $('#csrftoken').val();
    var folder              = $('#folder').val();
    var file                = $('#file').val();
    var id_data             = $('#id_data').val();
    var rows_selected       = [];
    var valid_on            = $("select[name=valid_on]").val();
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
            }), o("#datetime-datepicker3").flatpickr({
                enableTime: !0,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            }), o("#range-datepicker").flatpickr({
                mode: "range"
            })
        },
        t.prototype.init = function() {
            this.initFlatpickr()
        }, o.Components = new t, o.Components.Constructor = t
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.Components.init()
    }();
    // End Datepicker & Touchspin //

    // Element Discount //
    var page            = $('#page').val();
    if (page == 'create') {
        $('#collectible').hide();
        $('#code_voucher').hide();
        $('#type_discount').hide();
        $('#percent1').hide();
        $('#percent2').hide();
        $('#percent3').hide();
    } else {
        var type_voucher = $("select[name=type_voucher]").val();
        if (type_voucher == 'Collectible') {
            $('#collectible').show();
            $('#type_discount').show();
            $('#code_voucher').hide();
        } else {
            $('#code_voucher').show();
            $('#type_discount').show();
            $('#collectible').hide();
        }
        var val_radio = $("input[name='customRadio']:checked").val();
        if (val_radio == 'nominal') {
            $('#nominal1').show();
            $('#nominal2').show();
            $('#percent1').hide();
            $('#percent2').hide();
            $('#percent3').hide();
        } else {
            $('#nominal1').hide();
            $('#nominal2').hide();
            $('#percent1').show();
            $('#percent2').show();
            $('#percent3').show();
        }
    }
    $('select[name=type_voucher]').change(function(){
        $('#collectible').hide();
        $('#code_voucher').hide();
        var type_voucher = $(this).val();
        if (type_voucher == 'Collectible') {
            $('#collectible').show();
            $('#type_discount').show();
        } else if (type_voucher == 'Code Voucher') {
            $('#code_voucher').show();
            $('#type_discount').show();
        } else {
            $('#collectible').hide();
            $('#code_voucher').hide();
            $('#type_discount').hide();
        }
    });
    $(document).on('click', '#customRadio2', function() {
        $('#nominal1').show();
        $('#nominal2').show();
        $('#percent1').hide();
        $('#percent2').hide();
        $('#percent3').hide();
    });
    $(document).on('click', '#customRadio1', function() {
        $('#nominal1').hide();
        $('#nominal2').hide();
        $('#percent1').show();
        $('#percent2').show();
        $('#percent3').show();
    });
    // End Element Discount //

    // Format Number //
    for (xi = 1; xi <= 4; xi++) {
        $(document).on('keyup', '#inlineFormInputGroup'+xi, function(e){
            if(event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
        });
    }
    // End Format Number //

    // Datatable
    // var table = $('#basic-datatable').DataTable({
    //     "processing": true, 
    //     "serverSide": true, 
        
    //     "ajax":  
    //         {
    //             "url": base_url + '/webadmin/' + folder + '/' + file + '/get_data_json2/',
    //             "type": "POST",
    //             "data": {[csrfName]:csrfHash, page:page, id_data:id_data},
    //         },
    //     // "orderData": [[ 1, 'asc' ]],
    //     "columns": [
    //         {
    //             "data": "event_id",
    //             'targets': 0,
    //             'className': 'dt-body-center',
    //             "orderable": false,
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
    //     "columnDefs": [
    //         { "orderable": false, "targets": [0, 1, 2, 3] }
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

