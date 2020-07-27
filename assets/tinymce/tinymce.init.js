var base_url = window.location.origin;


function getThemes (name) {
  var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
  return v ? v[2] : null;
};

var getThemes = getThemes("themes");

if(getThemes == 'dark'){
  var skin = 'darkgray';
} else {
  var skin = 'lightgray';
}

  tinymce.init({
    selector: '#content',
    height: 600,
    remove_script_host: false,
    relative_urls: false,
    skin: skin,
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

