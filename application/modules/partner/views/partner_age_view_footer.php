<script type="text/javascript">
	$().ready(function(){
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#second").hide();
		$("#first").show();
		// $("#age_outcomes").load("<?php //echo baase_url();?>charts/ages/age_outcomes");
		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes'); ?>");

		$("#partner").change(function(){
			part = $(this).val();
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
	        
	        // Put the results in a div
	        posting.done(function( data ) {
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
	        	// Condition to dispay the proper divs based on whether a partner is selected or not

	        	if (data=='null') {
	        		$("#second").hide();
					$("#first").show();
					// fetching the partner outcomes
					$("#age_outcomes").html("<center><div class='loader'></div></center>");
					$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes'); ?>");
	        	} else {
	        		data = JSON.parse(data);
	        		// alert(data);
	        		$("#second").hide();
					$("#first").show();
					// fetching the partner outcomes
					$("#age_outcomes").html("<center><div class='loader'></div></center>");
					$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        	}
	        });
		});

		$("#age_category").change(function(){
			age = $(this).val();
			$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
				partner = JSON.parse(data);
				if (age=="") {
					$("#second").hide();
					$("#first").show();
					
					$("#age_outcomes").html("<center><div class='loader'></div></center>");
					$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+partner);
				} else {
					$("#first").hide();
					$("#second").show();

					$("#samples").html("<center><div class='loader'></div></center>");
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#county").html("<center><div class='loader'></div></center>");

					$("#samples").load();
					$("#vlOutcomes").load();
					$("#gender").load();
					$("#county").load();
				}
			});
		});
	});
</script>