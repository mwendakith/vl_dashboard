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

		// Subcounty dropdown select event habdler
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
		// Subcounty dropdown select event habdler

		// PMTCT dropdown select event habdler
		$("#sub_county_pmtct").change(function(){
			em = $(this).val();
			console.log(em);
			localStorage.setItem("subcounty_pmtct", em);
			$.get("<?= @base_url('county/check_subcounty_select');?>", function(data){
				subCounty = JSON.parse(data);
				if (subCounty == 0) {
					alert("Select a Sub-County first");
				}else {
					if (em == "NA") {
						$("#first").hide();
						$("#second").show();
						$("#third").hide();
						$("#fourth").hide();

						$("#pmtct_outcomes_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_sup_outcomes_div").html("<center><div class='loader'></div></center>");
						$("pmtct_suppression_all_div").html("<center><div class='loader'></div></center>");
						$("pmtct_vl_outcomes_all_div").html("<center><div class='loader'></div></center>");

						$("#pmtct_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+1+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_sup_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+2+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);

						// Should be showing removed temporarily
						$("#pmtct_suppression_all_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_vl_outcomes_all_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);
					} else {
						$("#first").hide();
						$("#second").hide();
						$("#third").show();
						$("#fourth").hide();

						$("#pmtct_suppression_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_vl_outcomes_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_counties_listing_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_partners_listing_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_sites_listing_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_counties_outcomes_div").html("<center><div class='loader'></div></center>");

						$("#pmtct_suppression_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_vl_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_counties_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_partners_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_sites_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+subCounty);
						$("#pmtct_counties_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+null+"/"+subCounty);
					}
				}
			});
		});
		// PMTCT dropdown select event habdler
	});
</script>