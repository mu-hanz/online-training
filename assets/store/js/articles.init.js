
(function ($) {

    $('#sidebar').theiaStickySidebar({
        additionalMarginTop: 150
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
        url: base_url + '/articles/all-articles/ajax',
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