<script type="text/javascript">
	$().ready(function () {
		$("#breadcrum").html("All Funding Agencies");
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
    	$.get("<?php echo base_url();?>template/get_current_header", function(data){
			$(".display_current_range").html(data);
    	});
		$("#second").hide();
		$("#third").hide();
		// fetching the partner outcomes
		$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>");
		
		// fetching the data for a specific partner
		$("select").change(function(){
			fun_agency = $(this).val();
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_funding_agency_data", { agency: fun_agency } );
	        
	        // Put the results in a div
	        posting.done(function( data ) {
	        	data = $.parseJSON(data);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+null+"/"+null+"/"+null+"/"+5, function(data){
	        		$("#breadcrum").html(data);
	        	});
	        	$.get("<?php echo base_url();?>template/dates", function(data){
		    		obj = $.parseJSON(data);
			
					if(obj['month'] == "null" || obj['month'] == null){
						obj['month'] = "";
					}
					$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
		    	});
	        	// Condition to dispay the proper divs based on whether a partner is selected or not
	        	
	        	if (data==null) {
	        		$("#second").hide();
					$("#third").hide();
					// fetching the partner outcomes
					$("#agency_div").html("<center><div class='loader'></div></center>");
					$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>");
	        	} else {
	        		
	        		
	        	}
	        });
		});

		$("button").click(function () {
			var all = localStorage.getItem("my_var");
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
			    $.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
					partner = data;
					
					if (partner==0) {
						$("#second").hide();
						$("#third").hide();
						// fetching the Agencies outcomes
						$("#agency_div").html("<center><div class='loader'></div></center>");
						$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						partner = $.parseJSON(partner);
												
					}
				});
			}
		    
		});
	});

	function date_filter(criteria, id)
	{
		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var all = localStorage.getItem("my_var");
 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
				partner = data;
				
				if (partner==0) {
					$("#second").hide();
					$("#third").hide();
					// fetching the partner outcomes
					$("#agency_div").html("<center><div class='loader'></div></center>");
					$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+year+"/"+month);
				} else {
					partner = $.parseJSON(partner);
					
				}
			});
		});
	}
</script>