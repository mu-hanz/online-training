(function ($) {
// Sticky sidebar
$('#sidebar').theiaStickySidebar({
    additionalMarginTop: 150
});



/*  video popups */
$('.video').magnificPopup({type:'iframe'});	/* video modal*/
	
/*  Image popups */
$('.magnific-gallery').each(function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        },
        removalDelay: 500, //delay removal by X to allow out-animation
        callbacks: {
            beforeOpen: function () {
                // just a hack that adds mfp-anim class to markup 
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
        closeOnContentClick: true,
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });
});


var loadmoreBtn = $('#loadmore');
loadmoreBtn.click(function() {
  
    // disable button
    $(this).prop("disabled", true);
    // add spinner to button
    $(this).html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
    );
    var page = $(this).data('page');
    getDataEvent(page);

});

var getcsrf  = function(name){
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
};

var getDataEvent = function(page){
    var base_url        = window.location.origin;

    $.ajax({
        url: base_url + '/events/all-events/ajax',
        type: 'POST',
        data: {
            'offset': page,
            'mz_token': getcsrf("mz_cookie")
            }
        }).done(function(response) {

            $("#data-event").append(response).fadeIn(1000);;
            loadmoreBtn.prop("disabled", false);
            loadmoreBtn.html('Load More');
            loadmoreBtn.data('page', (loadmoreBtn.data('page')+1));
            scroll();
            //refresh pjax
            var newContent = document.querySelector(".new-grid");
            pjax.refresh(newContent);
        
    });
};

var scroll  = function(){
    $('html, body').animate({
        scrollTop: loadmoreBtn.offset().top  - 710
    }, 1000);
};





})(window.jQuery); 