var muhanz = (function(muhanz) {
  "use strict";

  // For check element
	$.fn.exists = function(callback) {
		var args = [].slice.call(arguments, 1);
		if (this.length) {
			callback.call(this, args);
		}
		return this;
	};

  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };


  muhanz = {
      afterDOMReady: function() {
          this.activeNav();
          this.getcsrf();
          this.select2();
		  this.select21();
		  this.datatables();
		  this.datetimenow()
      },

	  datetimenow: function(){
		  moment.locale('id');
		  function updateTime() {
			  const datetime = moment().format("dddd Do MMM, h:mm:ss");
			  $('#date-now').text(datetime);
		  }
		  setInterval(function(){
			  updateTime();
		  },1);
	  },

	  select2: function() {
		  $('.select2').exists(function() {
			  this.select2({
				  language: "id",
				  placeholder: 'Pilih Kategori',
			  });
		  });
	  },

	  select21: function() {
		  function formatState (state) {
			  if (!state.id) {
				  return state.text;
			  }
			  var parent = $(state.element).data('parent');

			  if(parent != "0"){
				  var text = state.text.replace('—','');
				  var $state = $(
					  '<span>'+ $(state.element).data('parent') +' <i class="feather icon-arrow-right mr-0"></i>'+ text +'</span>'
				  );
			  } else {
				  var $state = state.text;
			  }


			  return $state;
		  };
		  $('.select21').exists(function() {
			  this.select2({
				  templateSelection: formatState,
				  placeholder: 'Pilih Kategori',
			  });
		  });
	  },

	  datatables: function() {
		  $('[datatables]').exists(function() {
		  this.DataTable({
			  "ordering": false,
			  "autoWidth": false,
			  "language": {
				  "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
			  },
			  "initComplete": function () {
				  $('.show-table').fadeIn();
			  },
			  columnDefs: [{
				  orderable: false,
				  targets: [0]
			  }]
		  });
		  });
	  },

      activeNav: function() {
		$('#topnav-menu li a').each(function () {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass('active');
				$(this).parent().parent().addClass('active'); // add active to li of the current link
				$(this).parent().parent().parent().parent().addClass('active');
				$(this).parent().parent().parent().parent().parent().parent().addClass('active');
			}
		});

		$('#topnav-menu .dropdown-menu a.dropdown-toggle').on('click', function () {
			// console.log("hello");
			if (
				!$(this)
					.next()
					.hasClass('show')
			) {
				$(this)
					.parents('.dropdown-menu')
					.first()
					.find('.show')
					.removeClass('show');
			}
			var $subMenu = $(this).next('.dropdown-menu');
			$subMenu.toggleClass('show');

			return false;
		});
      },



      getcsrf: function(name) {
          var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
          return v ? v[2] : null;
      },
  };
  $(document).ready(function() {
      muhanz.afterDOMReady();
      
  });
  return muhanz;
}(muhanz || {}));
