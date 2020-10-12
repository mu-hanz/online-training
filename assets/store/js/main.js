(function ($) {

	"use strict";
	
	$(window).on('load', function () {
		$('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
		$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('body').delay(350);
		$('#hero_in h1,#hero_in form').addClass('animated');
		$('.hero_single, #hero_in').addClass('start_bg_zoom');
		$(window).scroll();
	});
	
	
	
	
	// Mobile Mmenu
	var $menu = $("nav#menu").mmenu({
		"extensions": ["pagedim-black"],
		counters: false,
		keyboardNavigation: {
			enable: true,
			enhance: true
		},
		navbar: {
			title: 'MENU'
		},
		navbars: [{position:'bottom',content: ['<a href="'+window.location.origin+'">© 2020 Training Center</a>']}]}, 
		{
		// configuration
		clone: true,
		classNames: {
			fixedElements: {
				fixed: "menu_2",
				sticky: "sticky"
			}
		}
	});

	var $icon = $("#hamburger");
	var API = $menu.data("mmenu");
	$icon.on("click", function () {
		API.open();
	});
	API.bind("open:finish", function () {
		setTimeout(function () {
			$icon.addClass("is-active");
		}, 100);
	});
	API.bind("close:finish", function () {
		setTimeout(function () {
			$icon.removeClass("is-active");
		}, 100);
	});
    
    // Header button explore
    $('a[href^="#"].btn_explore').on('click', function (e) {
			e.preventDefault();
			var target = this.hash;
			var $target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top
			}, 800, 'swing', function () {
				window.location.hash = target;
			});
		});
	
	// WoW - animation on scroll
	var wow = new WOW(
	  {
		boxClass:     'wow',      // animated element css class (default is wow)
		animateClass: 'animated', // animation css class (default is animated)
		offset:       0,          // distance to the element when triggering the animation (default is 0)
		mobile:       true,       // trigger animations on mobile devices (default is true)
		live:         true,       // act on asynchronously loaded content (default is true)
		callback:     function(box) {
		  // the callback is fired every time an animation is started
		  // the argument that is passed in is the DOM node being animated
		},
		scrollContainer: null // optional scroll container selector, otherwise use window
	  }
	);
	wow.init();
    

		var base_url        = window.location.origin;
	function logPop(token){
		var loginVar="";
			loginVar += "<div id='popEl' class='form-body without-side'>";
			loginVar += "        <div class='row'>";
			loginVar += "            <div class='form-holder'>";
			loginVar += "                <div class='form-content'>";
			loginVar += "                    <div class='form-items'>";
			loginVar += "        <div class='website-logo'>";
			loginVar += "            <a href='" + base_url +"'>";
			loginVar += "                <div>";
			loginVar += "                    <img class='logo-size' src='" + base_url +"/assets/store/img/logo_black_2x.png' alt='Training Center'>";
			loginVar += "                </div>";
			loginVar += "            </a>";
			loginVar += "        </div>";
			loginVar += "                        <h3>Masuk ke akun saya</h3>";
			loginVar += "                        <p>Access to the most powerfull<br> Online and Virtual Training.</p>";
			loginVar += "                        <form class='ajaxFormAuth' action='" + base_url + "/webadmin/auth/auth/login' method='post'>";
			loginVar += "                        <input type='hidden' id='mz-csrf' name='mz_token' value='"+token+"'>";
			loginVar += "                            <input class='form-control' type='text' name='identity' placeholder='Email' required=''>";
			loginVar += "                            <input class='form-control' type='password' name='password' placeholder='Password' required=''>";
			loginVar += "                            <div class='form-button'>";
			loginVar += "                                <button id='submit' type='submit' class='ibtn'>Masuk</button> <a href='#' class='resetPassword' data-id='3'>Lupa password?</a>";
			loginVar += "                            </div>";
			loginVar += "                        </form>";
			loginVar += "                        <div class='other-links'>";
			loginVar += "                            <div class='text'>Atau</div>";
			loginVar += "                            <a href='#'><i class='fab fa-google'></i>Google</a>";
			loginVar += "                            <a href='#' class='register' data-id='2'><i class='fas fa-user-plus'></i> Daftar baru</a>";
			loginVar += "                          ";
			loginVar += "                        </div>";
			loginVar += "                    </div>";
			loginVar += "                </div>";
			loginVar += "            </div>";
			loginVar += "        </div>";
			loginVar += "    </div>";

			return loginVar;
		}

		function regPop(token){
			var regVar="";
			regVar += "<div id='popEl' class='form-body without-side'>";
			regVar += "        <div class='row'>";
			regVar += "            <div class='form-holder'>";
			regVar += "                <div class='form-content'>";
			regVar += "                    <div class='form-items'>";
			regVar += "        <div class='website-logo'>";
			regVar += "            <a href='" + base_url +"'>";
			regVar += "                <div>";
			regVar += "                    <img class='logo-size' src='" + base_url +"/assets/store/img/logo_black_2x.png' alt='Training Center'>";
			regVar += "                </div>";
			regVar += "            </a>";
			regVar += "        </div>";
			regVar += "                        <h3>Daftar Akun Baru</h3>";
			regVar += "                        <p>Access to the most powerfull<br> Online and Virtual Training.</p>";
			regVar += "                        <form class='ajaxFormAuth' action='" + base_url + "/webadmin/auth/auth/create_user' method='post'>";
			regVar += "                        <input type='hidden' id='mz-csrf-reg' name='mz_token' value='"+token+"'>";
			regVar += "						   <div class='form-row'>";
			regVar += "                          <div class='col'>";
			regVar += "                               <input type='text' class='form-control' name='first_name' placeholder='Nama depan' required=''>";
			regVar += "                           </div>";
			regVar += "                           <div class='col'>";
			regVar += "                                <input type='text' class='form-control' name='last_name' placeholder='Nama belakang' required=''>";
			regVar += "                           </div>";
			regVar += "                         </div>";
			regVar += "                            <input class='form-control' type='text' name='email' placeholder='Email' required=''>";
			regVar += "                            <input class='form-control' type='password' name='password' placeholder='Password' required=''>";
			regVar += "                            <div class='form-button'> ";
			regVar += "                                <button id='submit' type='submit' class='ibtn'>Daftar</button><a href='#' class='resetPassword' data-id='3'>Lupa password?</a>";
			regVar += "                            </div>";
			regVar += "                        </form>";
			regVar += "                        <div class='other-links'>";
			regVar += "                            <div class='text'>Atau</div>";
			regVar += "                            <a href='#'><i class='fab fa-google'></i>Google</a>";
			regVar += "                               <a href='#' class='loginpop' data-id='1'><i class='fas fa-lock'></i> Login ke akun saya</a>";
			regVar += "                          ";
			regVar += "                        </div>";
			regVar += "                    </div>";
			regVar += "                </div>";
			regVar += "            </div>";
			regVar += "        </div>";
			regVar += "    </div>";
			return regVar;
		}

		function lostPop(token){
			var lostVar="";
				lostVar += "<div id='popEl' class='form-body without-side'>";
				lostVar += "        <div class='row'>";
				lostVar += "            <div class='form-holder'>";
				lostVar += "                <div class='form-content'>";
				lostVar += "                    <div class='form-items'>";
				lostVar += "        <div class='website-logo'>";
				lostVar += "            <a href='" + base_url +"'>";
				lostVar += "                <div>";
				lostVar += "                    <img class='logo-size' src='" + base_url +"/assets/store/img/logo_black_2x.png' alt='Training Center'>";
				lostVar += "                </div>";
				lostVar += "            </a>";
				lostVar += "        </div>";
				lostVar += "                        <h3>Password Reset</h3>";
				lostVar += "                        <p>Untuk mengatur ulang kata sandi Anda, masukkan alamat email</p>";
				lostVar += "                        <form class='ajaxFormAuth' action='" + base_url + "/webadmin/auth/auth/login' method='post'>";
				lostVar += "                        <input type='hidden' id='mz-csrf' name='mz_token' value='"+token+"'>";
				lostVar += "                            <input class='form-control' type='text' name='identity' placeholder='Email' required=''>";
				lostVar += "                            <div class='form-button full-width'>";
				lostVar += "                                <button id='submit' type='submit' class='ibtn btn-forget'>Kirim link reset</button>";
				lostVar += "                            </div>";
				lostVar += "                        </form>";
				lostVar += "                        <div class='page-links'>";
				lostVar += "                            <div class='other-links'>";
				lostVar += "                            <div class='text'>Atau</div>";
				lostVar += "                                 <a href='#' class='loginpop' data-id='1'><i class='fas fa-lock'></i> Login ke akun saya</a>";
				lostVar += "                                 <a href='#' class='register' data-id='2'><i class='fas fa-user-plus'></i> Buat akun baru</a>";
				lostVar += "                            </div>";
				lostVar += "                        </div>";
				lostVar += "                    </div>";
				lostVar += "                </div>";
				lostVar += "            </div>";
				lostVar += "        </div>";
				lostVar += "    </div>";
		
				return lostVar;
			}



	function get_token(name){
		var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
		return v ? v[2] : null;
	}

	  $(document).on('click', '.loginpop, .register, .resetPassword', function () {

		var varDom;
		if($(this).data( "id" ) == 1){
			varDom = logPop(get_token("mz_cookie"));
		} else if($(this).data( "id" ) == 2) {
			varDom = regPop(get_token("mz_cookie"));
		} else {
			varDom = lostPop(get_token("mz_cookie"));
		}

			$.magnificPopup.open({
				items: {
					src: varDom,
					type: 'inline',
				},
				closeOnBgClick : false,
				closeBtnInside:true,
				removalDelay: 300,
				mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		
				zoom: {
					enabled: true, // By default it's false, so don't forget to enable it
		
					duration: 300, // duration of the effect, in milliseconds
					easing: 'ease-in-out', // CSS transition easing function
		
					
				}
			});
	
	  });


	//   $(document).on('click', '.login', function () {
	 
	// 	// $.magnificPopup.close();
	// 		$.magnificPopup.open({
	// 			items: {
	// 				src: loginVar,
	// 				type: 'inline',
	// 			},
	// 			closeOnBgClick : false,
	// 			removalDelay: 300,
	// 			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		
	// 			zoom: {
	// 				enabled: true, // By default it's false, so don't forget to enable it
		
	// 				duration: 300, // duration of the effect, in milliseconds
	// 				easing: 'ease-in-out', // CSS transition easing function
		
					
	// 			},
	// 			callbacks: {
	// 				open: function() {
	// 					$('#mz-csrf').val(get_token("mz_cookie"))
	// 				},
	// 				change: function() {
	// 				  console.log('Content changed2');
	// 				  console.log(this.content); // Direct reference to your popup element
	// 				},
	// 			}
	// 		});
	
	//   });




	 
// Sticky nav
$(window).on('scroll', function () {
    if ($(this).scrollTop() > 1) {
        $('.header').addClass("sticky");
    } else {
        $('.header').removeClass("sticky");
    }
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
	
	// tooltips
	 $('[data-toggle="tooltip"]').tooltip();
	
	// Accordion
	function toggleChevron(e) {
		$(e.target)
			.prev('.card-header')
			.find("i.indicator")
			.toggleClass('ti-minus ti-plus');
	}
	$('#accordion_lessons').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
		function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".indicator")
            .toggleClass('ti-minus ti-plus');
    }
    // Accordion 2 (updated v1.2)
	$('.accordion_2').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);
		function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".indicator")
            .toggleClass('ti-minus ti-plus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
	
	  
	// Input field effect
	(function () {
		if (!String.prototype.trim) {
			(function () {
				// Make sure we trim BOM and NBSP
				var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
				String.prototype.trim = function () {
					return this.replace(rtrim, '');
				};
			})();
		}
		[].slice.call(document.querySelectorAll('input.input_field, textarea.input_field')).forEach(function (inputEl) {
			// in case the input is already filled..
			if (inputEl.value.trim() !== '') {
				classie.add(inputEl.parentNode, 'input--filled');
			}

			// events:
			inputEl.addEventListener('focus', onInputFocus);
			inputEl.addEventListener('blur', onInputBlur);
		});
		function onInputFocus(ev) {
			classie.add(ev.target.parentNode, 'input--filled');
		}
		function onInputBlur(ev) {
			if (ev.target.value.trim() === '') {
				classie.remove(ev.target.parentNode, 'input--filled');
			}
		}
	})();
	
	// Selectbox
	$(".selectbox").selectbox();

	// Check and radio input styles
	$('input.icheck').iCheck({
		checkboxClass: 'icheckbox_square-grey',
		radioClass: 'iradio_square-grey'
	});
	
	// Carousels
	$('#carousel').owlCarousel({
		center: true,
		items: 2,
		loop: true,
		margin: 10,
		responsive: {
			0: {
				items: 1,
				dots:false
			},
			600: {
				items: 2
			},
			1000: {
				items: 4
			}
		}
	});
	
	

	// Sticky filters
	$(window).bind('load resize', function () {
		var width = $(window).width();
		if (width <= 991) {
			$('.sticky_horizontal').stick_in_parent({
				offset_top: 50
			});
		} else {
			$('.sticky_horizontal').stick_in_parent({
				offset_top: 73
			});
		}
	});
	            
	// Secondary nav scroll
	var $sticky_nav= $('.secondary_nav');
	$sticky_nav.find('a').on('click', function(e) {
		e.preventDefault();
		var target = this.hash;
		var $target = $(target);
		$('html, body').animate({
			'scrollTop': $target.offset().top - 150
		}, 800, 'swing');
	});
	$sticky_nav.find('ul li a').on('click', function () {
		$sticky_nav.find('ul li a.active').removeClass('active');
		$(this).addClass('active');
	});
	
	// Faq section (updated v1.2)
	$('#faq_box a[href^="#"]').on('click', function () {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
			|| location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			   if (target.length) {
				 $('html,body').animate({
					 scrollTop: target.offset().top -185
				}, 800);
				return false;
			}
		}
	});
	$('ul#cat_nav li a').on('click', function () {
		$('ul#cat_nav li a.active').removeClass('active');
		$(this).addClass('active');
	});
	
})(window.jQuery); 