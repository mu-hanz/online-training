var base_url = window.location.origin;

  tinymce.init({
    selector: '#content',
    height: 600,
    remove_script_host: false,
    relative_urls: false,
    theme: 'modern',
    branding: false,
    plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor code toc insertdatetime advlist lists textcolor wordcount imagetools  contextmenu colorpicker textpattern',
    toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist removeformat code',
 
    external_filemanager_path: base_url + "/media/filemanager/",
		filemanager_title: "Media Manager",
		// filemanager_sort_by : users_folder,
		filemanager_access_key: "191a7cb7086e4e399cf2e76d6ca7b501",
		external_plugins: {
			"filemanager": base_url + "/media/filemanager/plugin.min.js"
		},
  })

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
