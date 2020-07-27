(function ($) {


		$('#carousel_slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 280,
			itemMargin: 25,
			asNavFor: '#slider'
		});
		$('#carousel_slider ul.slides li').on('mouseover', function() {
			$(this).trigger('click');
		});
		$('#slider').flexslider({
			animation: "fade",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			sync: "#carousel_slider",
			start: function(slider) {
				$('body').removeClass('loading');
			}
		});

		$('#reccomended').owlCarousel({
			center: true,
			items: 2,
			loop: true,
			autoplay:true,
			autoplayTimeout:2000,
			margin: 0,
			responsive: {
				0: {
					items: 1
				},
				767: {
					items: 2
				},
				1000: {
					items: 3
				},
				1400: {
					items: 4
				}
			}
		});
})(window.jQuery); 