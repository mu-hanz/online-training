$(document).ready(function() {

    // All Variable //
    var base_url                        = window.location.origin;
    var folder                          = $('#folder').val();
    var file                            = $('#file').val();
    var id_data                         = $('#id_data').val();
    var rows_selected                   = [];
    var page                            = $('#page').val();
    var csrfName                        = $("#csrftoken").attr("name");
    var csrfHash                        = $('#csrftoken').val();
    var count_data_product_media_images = $('#count_data_product_media_images').val();
    var count_data_product_media_files  = $('#count_data_product_media_files').val();
    // End All Variable //

    // Add Row //
    $("#addRow").click(function () {
        var html = '';
        html += '<div class="form-group row" id="inputFormRow">';
        html += '<div class="col-lg-8">';
        html += '<label for="promotionName">Image</label>';
        html += '<input type="file" class="form-control" name="file_image[]" id="example-fileinput">';
        html += '</div>';
        html += '<div class="col-lg-2">';
        html += '<label for="promotionName">Ordering</label>';
        html += '<input type="text" class="form-control" name="ordering_image[]" id="simpleinput">';
        html += '</div>';
        html += '<div class="col-lg-2 text-right">';
        html += '<button id="removeRow" type="button" class="btn btn-danger remove-btn-removeRow">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });

    $("#addRowFile").click(function () {
        var html = '';
        html += '<div class="form-group row" id="inputFormRowFile">';
        html += '<div class="col-lg-10">';
        html += '<label for="promotionName">File</label>';
        html += '<input type="file" class="form-control" name="file_upload[]" id="example-fileinput">';
        html += '</div>';
        // html += '<div class="col-lg-2">';
        // html += '<label for="promotionName">Ordering</label>';
        // html += '<input type="text" class="form-control" name="ordering_file[]" id="simpleinput">';
        // html += '</div>';
        html += '<div class="col-lg-2 text-right">';
        html += '<button id="removeRowFile" type="button" class="btn btn-danger remove-btn-removeRow">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#newRowFile').append(html);
    });

    // remove row
    $(document).on('click', '#removeRowFile', function () {
        $(this).closest('#inputFormRowFile').remove();
    });

    for (xi = 1; xi <= count_data_product_media_images; xi++) {
        $(document).on('click', '#removeRowEdit'+xi, xi, function (e) {
            var xix     = e.data;
            var xcx     = $("#product_media_image_id"+xix).val();
            var html    = '';
            html += '<input type="hidden" class="form-control" value="'+xcx+'" name="image_remove[]">';
            $('#newRowEdit'+xix).append(html);
            $('#inputFormRowEdit'+xix).remove(); 
        });
    }

    for (xi = 1; xi <= count_data_product_media_files; xi++) {
        $(document).on('click', '#removeRowFileEdit'+xi, xi, function (e) {
            var xix     = e.data;
            var xcx     = $("#product_media_file_id"+xix).val();
            var html    = '';
            html += '<input type="hidden" class="form-control" value="'+xcx+'" name="file_remove[]">';
            $('#newRowFileEdit'+xix).append(html);
            $('#inputFormRowFileEdit'+xix).remove(); 
        });
    }
    // End Add Row //

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

});

