var muhanz = (function(muhanz) {
  "use strict";
  	var base_url = window.location.origin;

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


	// For check element
	$.fn.exists = function(callback) {
		var args = [].slice.call(arguments, 1);
		if (this.length) {
			callback.call(this, args);
		}
		return this;
	};

	$(document).on('change','.changeThemes',function(){

		
		if($(this).is(':checked'))
		{
			var val = '1';
		}
		else
		{
			var val = '0';
		}

		var csrf =  muhanz.getcsrf("mz_cookie");
          $.ajax({
              url: base_url + '/webadmin/settings/change_themes',
              type: 'POST',
              data: {
                  'themes': val,
                  'mz_token': csrf
              },
              success: function() {
				window.location.href
				setTimeout(() => window.location.reload());
              }
          });
	});

	
  muhanz = {
      afterDOMReady: function() {
		  this.getcsrf();
		  this.activeNav();
		  this.DataTable();
      },
		  
	  	getcsrf: function(name) {
			var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
			return v ? v[2] : null;
		},

		DataTable: function() {
			$('#datatable').exists(function() {
				this.DataTable({

					ordering: false,
					autoWidth: false,
					initComplete: function () {
						$('.show-table').fadeIn();
					},
					columnDefs: [{
						orderable: false,
						targets: [0]
					}],
							
					language: {
						paginate: {
							previous: "<i class='uil uil-angle-left'>",
							next: "<i class='uil uil-angle-right'>"
						}
					},
					drawCallback: function() {
						$(".dataTables_paginate > .pagination").addClass("pagination-rounded")
					}
				});
			})
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
					$(this).parent().removeClass("mm-active");
					$(this).parent().parent().removeClass("mm-show");
					$(this).parent().parent().parent().removeClass("mm-active");
			}
			this.$window = $(window);
				if (this.$window.width() <= 768) {
				$('.button-menu-mobile').removeClass("open");
				$('#topnav-menu-content').slideUp(400);
			}

		});

      }

  };
  $(document).ready(function() {
      muhanz.afterDOMReady();
  });
  return muhanz;
}(muhanz || {}));
