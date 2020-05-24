$(document).ready(function() {

    // All Variable //
    var base_url                = window.location.origin;
    var folder                  = $('#folder').val();
    var file                    = $('#file').val();
    var id_data                 = $('#id_data').val();
    var rows_selected           = [];
    var page                    = $('#page').val();
    var csrfName                = $("#csrftoken").attr("name");
    var csrfHash                = $('#csrftoken').val();
    var count_data_training     = $('#count_data_training').val();
    var valid_on                = $("select[name=valid_on]").val();
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

    // Datepicker //
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
        t.prototype.init = function() {
            this.initFlatpickr()
        }, o.Components = new t, o.Components.Constructor = t
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.Components.init()
    }();
    // End Datepicker //

    // Summernote //
    $("#summernote-editor").summernote({ 
        height: 250, 
        minHeight: null, 
        maxHeight: null, 
        focus: !1,
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            },
            onMediaDelete: function(target) {
                deleteImage(target[0].src);
            }
        }
    })
    function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        data.append([csrfName], csrfHash);
        $.ajax({
            url: base_url + '/webadmin/' + folder + '/' + file + '/upload_image_summernote/',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(url) {
                $('#summernote-editor').summernote("insertImage", url);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    function deleteImage(src) {
        $.ajax({
            data: {src : src, [csrfName] : csrfHash},
            type: "POST",
            url: base_url + '/webadmin/' + folder + '/' + file + '/delete_image_summernote/',
            cache: false,
            success: function(response) {
                console.log(response);
            }
        });
    }
    // End Summernote //

    // Format Number //
    for (xi = 1; xi <= count_data_training; xi++) {
        $(document).on('keyup', '#price-campaign'+xi, function(e){
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

    // Datatable //
    var tablex = $('#basic-datatable').DataTable({
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center'
        },{
            'targets': 2,
            'orderable': false,
        },{
            'targets': 3,
            'orderable': false,
        }],
        'order': [[1, 'asc']]
    });
    // End Datatable //

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

