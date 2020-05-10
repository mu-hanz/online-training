
var base_url = window.location.origin;

$("#modal-media").modal({
    show:false,
    backdrop:'static'
});

$(".open_media").click(function(e) {
e.preventDefault();
var id = $(this).attr('data-id');
var url_media = base_url + '/media/filemanager/dialog.php?type=1&descending=0&field_id=' + id + '&akey=191a7cb7086e4e399cf2e76d6ca7b501';
$('#frame_media').attr('src', url_media);
$("#modal-media").modal();
});

window.responsive_filemanager_callback = function(field_id) {
var url = jQuery('#' + field_id).val();
$('#' + field_id).attr('src', url);
$('#post_'+field_id).val(url);
$('#overlay-'+field_id).addClass('box-overlay');
jQuery("#modal-media").modal("hide");
}

$(".remove-images").click(function(e) {
e.preventDefault();
var field_id = $(this).attr('data-id');
$('#post_'+field_id).val();
$('#' + field_id).attr('src', base_url + '/assets/app/images/small/img-1.jpg');
$('#overlay-'+field_id).removeClass('box-overlay');
});

$("#draft").click(function() {
$("#form").prepend('<input type="hidden" name="draft" value="draft">');
});