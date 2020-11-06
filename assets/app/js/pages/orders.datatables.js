$(document).ready(function() {
    // datatable
    var base_url = window.location.origin;
    var csrf =  muhanz.getcsrf("mz_cookie");

    var table_el = $('#datatable-order');
    var table = table_el.DataTable({
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "autoWidth": false,
        "ajax": {
            "url": base_url + '/webadmin/orders/orders/json_orders',
            "type": "POST",
            "data": {
                'mz_token': csrf
            }
        },
        "drawCallback": function(settings) {
            //refresh pjax
            var newContent = document.querySelector(".data-list-view");
            pjax.refresh(newContent);
        },
        "initComplete": function(settings, json) {
            table.ajax.reload();
        },
        "columns": [  
			{
				className:      'details-control',
				orderable:      false,
				data:           null,
				defaultContent: '',
				searchable : false
			}, {
				"data": "order_id",
				'className': 'align-middle'
			},{
				"data": "total",
				'className': 'text-center',
				render: $.fn.dataTable.render.number( '.', '.', 0 )
			},{
				"data": "payment_type",
				'className': 'align-middle'
			},{
				"data": "payment_status"
			},{
				"data": "created_date",
			},{
				"data": "invoice",
			},{
				"data": "tools",
			}
		],
    });


    table_el.on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table.row( tr );
	
		if ( row.child.isShown() ) {
			row.child.hide();
			tr.removeClass('shown');
		}
		else {

			table.rows().every(function(){
				// If row has details expanded
				if(this.child.isShown()){
					// Collapse row details
					this.child.hide();
					$(this.node()).removeClass('shown');
				}
			});
		
			row.child( format(row.data()), 'highlightExpanded' ).show();
			tr.addClass('shown');
			
		}

    } );

    function format ( rowData ) {
		var result = $('<div/>')
			.addClass( 'loading' )
			.text( 'Loading...' );

		$.ajax( {
			url: base_url +'/webadmin/orders/orders/detail_order',
			data: {
				id : rowData.transaction_id,
				mz_token : csrf
			},
			type: 'POST',
			dataType: 'json',
			success: function ( json ) {
                var tbl = "<table class='table data-show  mb-0'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>No.</th>"+
                                    "<th class='text-center'>SKU</th>"+
                                    "<th>Event Name</th>"+
                                    "<th class='text-center'>Type</th>"+
                                    "<th class='text-center'>Total Person</th>"+
                                "</tr>"+
                            "</thead>"+
                           "<tbody>";
                var no = 1;
				for(  var i=0; i<json.length; i++) {

					tbl += "<tr>";
                        tbl += "<td width='7%'>"+ no++ +"</td>";
                        tbl += "<td class='text-center'>"+json[i].event_sku+"</td>";
						tbl += "<td>"+json[i].event_name+"</td>";
						tbl += "<td class='text-center'>"+json[i].event_type +"</td>";
                        tbl += "<td class='text-center'>"+json[i].qty+"</td>";
					tbl += "</tr>";
				}
				tbl += "</tbody>";
				tbl += "</table>";

				result.html( tbl ).removeClass( 'loading' );
			}
		} );
	 
		return result;
	}

	function addCommas(numberString) {
		var resultString = numberString + '',
			x = resultString.split('.'),
			x1 = x[0],
			x2 = x.length > 1 ? '.' + x[1] : '',
			rgxp = /(\d+)(\d{3})/;
	  
		while (rgxp.test(x1)) {
		  x1 = x1.replace(rgxp, '$1' + '.' + '$2');
		}
	  
		return x1 + x2;
	  }

});