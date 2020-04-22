var muhanz = (function(muhanz) {
  "use strict";

    $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
   
    //initializing popover
    $.fn.popover && $('[data-toggle="popover"]').popover()

    //initializing Slimscroll
	//You can change the color of scroll bar here
	$.fn.slimScroll && $(".slimscroll").slimScroll({
		height: 'auto',
		position: 'right',
		size: "4px",
		touchScrollStep: 20,
		color: '#9ea5ab'
	});

	
  muhanz = {
      afterDOMReady: function() {
          this.activeNav();
      },


      activeNav: function() {

		$(".mz-menu a").each(function() {
			if (this.href == window.location.href) {
					$(this).parent().removeClass("active");
					$('li').removeClass("mm-active");
					$('li ul').removeClass("mm-show");
					$('li ul li a').removeClass("active");
					$('li a').removeClass("active");
					$('li a').attr("aria-expanded","false");
					$(this).addClass("active");
					$(this).parent().addClass("mm-active"); // add active to li of the current link
					$(this).parent().parent().addClass("mm-show");
					$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
					$(this).parent().parent().parent().addClass("mm-active");
					$(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
					$(this).parent().parent().parent().parent().parent().addClass("mm-active");

			}

			$('.button-menu-mobile').removeClass("open");
			$('#topnav-menu-content').slideUp(400);

		});

      }

  };
  $(document).ready(function() {
      muhanz.afterDOMReady();
  });
  return muhanz;
}(muhanz || {}));
