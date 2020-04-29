/**
 * ==================================
 * Created by MuHanz for Zaprim @2019
 * ==================================
 */

(function ($, undefined) {

  "use strict";

  // When ready.
  $(function () {

    var base_url = window.location.origin;

    // For check element
    $.fn.exists = function (callback) {
      if (this.length) {
        var args = [].slice.call(arguments, 1);
        callback.call(this, args);
      }
      return this;
    };

	  const btn_text_delete = "Ya, Hapus!";
	  const btn_text_cencel = "Batal";
	  const warning_text = "Anda tidak akan dapat mengembalikan ini!";
	  const warning_text_title = "Apakah anda yakin?";

  $(document).on('click', '.del', function(e) {
    e.preventDefault();

    var term_id = $(this).attr("term-id");
    var term_type = $(this).attr("term_type");
    var term_url = $(this).attr("term_url");
    
    Swal.fire({
      title: warning_text_title,
      text: warning_text,
      type: 'warning',
      width: '350px',
      showCancelButton: true,
      confirmButtonText: btn_text_delete,
      cancelButtonText: btn_text_cencel,
      reverseButtons: true,
      confirmButtonColor: "#6cc788",
      cancelButtonColor: '#f44455',
      allowOutsideClick: false,
    }).then((result) => {
      if (result.value) {
        var csrf =  muhanz.getcsrf("csrf_cookie_mz");
          $.ajax({
              url: base_url + '/' + term_url + '/' + term_type,
              type: 'POST',
              data: {
                  'term_id': term_id,
                  'csrf_token_mz': csrf
              },
              dataType: 'json',
              success: function(data) {

                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2500
                  });
                  
                  Toast.fire({
                    type: data.status,
                    title: data.message
                  })

                  pjax.options.requestOptions = {}
				          pjax.loadUrl(data.url, $.extend({}, pjax.options))
              }
          });
      } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
      ) {
        
      }
    })

});

  });
})(jQuery);
