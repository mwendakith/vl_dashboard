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
		// fetching the partner outcomes
		$("#partner_div").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

		$("#partner").change(function(){
			part = $(this).val();
			var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
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
	        	data = $.parseJSON(data);
	        	if (data==null) {
	        		$("#first").show();
	        		$("#second").hide();
					$("#third").hide();
					// fetching the partner outcomes
					$("#partner_div").html("<center><div class='loader'></div></center>");
					$("#partner_div").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
	        	} else {
	        		$("#first").hide();
	        		$("#second").show();
					$("#third").hide();
					$("#pmtct_outcomes_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_sup_outcomes_div").html("<center><div class='loader'></div></center>");

					$("#pmtct_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+1+"/"+null+"/"+null+"/"+data);
					$("#pmtct_sup_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+2+"/"+null+"/"+null+"/"+data);
	        	}
	        });
		});
	});
</script>