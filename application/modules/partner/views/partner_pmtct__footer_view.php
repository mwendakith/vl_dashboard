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
		$("#third").hide();
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

		$("#partner_pmtct").change(function(){
			em = $(this).val();
			$.get("<?= @base_url('partner/check_partner_select');?>", function(data){
				partner = JSON.parse(data);
				if (partner == 0) {
					alert("Select a partner first");
				}else {
					$("#first").hide();
	        		$("#second").hide();
					$("#third").show();

					$("#pmtct_suppression_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_vl_outcomes_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_counties_listing_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_partners_listing_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_sites_listing_div").html("<center><div class='loader'></div></center>");
					$("#pmtct_counties_outcomes_div").html("<center><div class='loader'></div></center>");

					$("#pmtct_suppression_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
					$("#pmtct_vl_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
					$("#pmtct_counties_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
					$("#pmtct_partners_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
					$("#pmtct_sites_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
					$("#pmtct_counties_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_counties_outcomes');?>/"+null+"/"+null+"/"+em+"/"+null+"/"+null+"/"+partner);
				}
			});
		});
	});
</script>