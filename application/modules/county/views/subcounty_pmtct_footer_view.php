<script type="text/javascript">
	$().ready(function(){
		localStorage.setItem("subcounty_pmtct", 0);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
    	
		$("#second").hide();
		$("#third").hide();
		$("#fourth").hide();

		$("#subcounty_div").load("<?= @base_url('charts/subcounties/subcounty_outcomes'); ?>");

		$("#sub_county_drpd").change(function(){
			em = $(this).val();
			var posting = $.post( "<?= @base_url();?>template/filter_sub_county_data", { subCounty: em } );
			// After setting the sub county data
			posting.done(function( subcounty ) {
				if (subcounty==null||subcounty=='null'||subcounty==undefined||subcounty=='') 
	        		subcounty = null
	        	$.get("<?php echo base_url();?>template/breadcrum/"+subcounty+"/"+null+"/"+null+"/"+1, function(data){
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
	        	if (em=="NA") {
	        		$("#first").show();
	        		$("#second").hide();
					$("#third").hide();
					$("#fourth").hide();
	        	} else {
	        		subcounty = JSON.parse(subcounty);
	        		$("#first").hide();
	        		$("#second").show();
					$("#third").hide();
					$("#fourth").hide();
					// Initialize the loader
					$("#pmtct_outcomes_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_sup_outcomes_div").html("<center><div class='loader'></div></center>");
					// Display the loaded data
					$("#pmtct_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+1+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
					$("#pmtct_sup_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+2+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
	        	} 
			});
		});
	});
</script>