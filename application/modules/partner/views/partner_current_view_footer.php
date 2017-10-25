<script type="text/javascript">
	$().ready(function(){

		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
			// console.log(obj);
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
    	$.get("<?php echo base_url();?>template/get_current_header", function(data){
			$(".display_current_range").html(data);
    	});

		$("#countys").html("<div>Loading...</div>");
		$("#partners").html("<div>Loading...</div>");
		$("#subcounty").html("<div>Loading...</div>");
		$("#facilities").html("<div>Loading...</div>");

		$("#current_sup").load("<?php echo base_url('charts/summaries/current_suppression'); ?>");

		$("#countys").load("<?php echo base_url('charts/summaries/county_listing_partner');?>");
		$("#partners").load("<?php echo base_url('charts/summaries/partner_listing_partner');?>");
		$("#subcounty").load("<?php echo base_url('charts/summaries/subcounty_listing_partner');?>");
		$("#facilities").load("<?php echo base_url('charts/summaries/site_listing_partner');?>");

		$("#long_tracking").load("<?php echo base_url('charts/summaries/get_patients'); ?>");

		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	     
	        // Put the results in a div
	        posting.done(function( partner ) {

	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
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

	        	data = JSON.parse(partner);

	        	// alert(data);
	        	$("#long_tracking").html("<center><div class='loader'></div></center>");
	        	$("#current_sup").html("<center><div class='loader'></div></center>");

				$("#countys").html("<div>Loading...</div>");
				$("#subcounty").html("<div>Loading...</div>");
				$("#facilities").html("<div>Loading...</div>");		

				$("#countys").load("<?php echo base_url('charts/summaries/county_listing_partner');?>/"+data);
				$("#subcounty").load("<?php echo base_url('charts/summaries/subcounty_listing_partner');?>/"+data);
				$("#facilities").load("<?php echo base_url('charts/summaries/site_listing_partner');?>/"+data);		
			
				$("#long_tracking").load("<?php echo base_url('charts/summaries/get_patients'); ?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#current_sup").load("<?php echo base_url('charts/summaries/current_suppression'); ?>/"+data);
	        });
		});

		$("button").click(function () {
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    var all = localStorage.getItem("my_var");
		    
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
	        	$("#long_tracking").html("<center><div class='loader'></div></center>");
				
		 		$("#long_tracking").load("<?php echo base_url('charts/summaries/get_patients'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]);
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

 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		
 		$("#long_tracking").html("<center><div class='loader'></div></center>");

		$("#long_tracking").load("<?php echo base_url('charts/summaries/get_patients'); ?>/"+year+"/"+month);
	}

	function expand_modal(div_name){
		$(div_name).modal('show');
	}
	
</script>