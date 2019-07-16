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

		// Button click event handler
		$("button").click(function () {
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
			    $.get("<?= @base_url();?>county/check_subcounty_select", function (data) {
					subCounty = data;
					
					if (subCounty==0) {
						$("#second").hide();
						$("#third").hide();
						$("#fourth").hide();
						// fetching the partner outcomes
						$("#subcounty_div").html("<center><div class='loader'></div></center>");
						$("#subcounty_div").load("<?= @base_url('charts/subcounties/subcounty_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						subCounty = $.parseJSON(subCounty);
						var all = localStorage.getItem("subcounty_pmtct");
						
						if (all == 'NA') {
							$("#first").hide();
			        		$("#second").show();
							$("#third").hide();
							$("#fourth").show();

							$("#pmtct_outcomes_div").html("<center><div class='loader'></div></center>");
							$("#pmtct_sup_outcomes_div").html("<center><div class='loader'></div></center>");
							$("pmtct_suppression_all_div").html("<center><div class='loader'></div></center>");
							$("pmtct_vl_outcomes_all_div").html("<center><div class='loader'></div></center>");

							$("#pmtct_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+1+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
							$("#pmtct_sup_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+2+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
							$("#pmtct_suppression_all_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
							$("#pmtct_vl_outcomes_all_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
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

							$("#pmtct_suppression_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
							$("#pmtct_vl_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+subCounty);
							$("#pmtct_counties_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+subCounty);
							$("#pmtct_partners_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+subCounty);
							$("#pmtct_sites_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+subCounty);
							$("#pmtct_counties_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct');?>/"+from[1]+"/"+from[0]+"/"+all+"/"+to[1]+"/"+to[0]+"/"+null+"/"+subCounty);
						}
					}
				});
			}
		    
		});
		// Button click event handler
	});

	// Year/Month filter handler
	function date_filter(criteria, id)
	{
		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		} else {
 			year = id;
 			month = null;
 		}
 		var posting = $.post( '<?= @base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null)
				obj['month'] = "";
			
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$.get("<?= @base_url();?>county/check_subcounty_select", function (data) {
				subcounty = JSON.parse(data);
				
				if (subcounty==0) {
					$("#first").show();
					$("#second").hide();
					$("#third").hide();
					$("#fourth").hide();
					// fetching the partner outcomes
					$("#subcounty_div").html("<center><div class='loader'></div></center>");
					$("#subcounty_div").load("<?= @base_url('charts/subcounties/subcounty_outcomes'); ?>/"+year+"/"+month);
				} else {
					var all = localStorage.getItem("subcounty_pmtct");
					if (all == 'NA') {
						$("#first").hide();
		        		$("#second").show();
						$("#third").hide();
						$("#fourth").hide();

						$("#pmtct_outcomes_div").html("<center><div class='loader'></div></center>");
						$("#pmtct_sup_outcomes_div").html("<center><div class='loader'></div></center>");
						$("pmtct_suppression_all_div").html("<center><div class='loader'></div></center>");
						$("pmtct_vl_outcomes_all_div").html("<center><div class='loader'></div></center>");

						$("#pmtct_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+year+"/"+month+"/"+1+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_sup_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+year+"/"+month+"/"+2+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);

						// Removed temporarily
						$("#pmtct_suppression_all_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_vl_outcomes_all_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
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

						$("#pmtct_suppression_div").load("<?= @base_url('charts/pmtct/pmtct_suppression');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_vl_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct_vl_outcomes');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_counties_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_partners_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_sites_listing_div").load("<?= @base_url('charts/pmtct/pmtct_breakdown');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+null+"/"+subcounty);
						$("#pmtct_counties_outcomes_div").load("<?= @base_url('charts/pmtct/pmtct');?>/"+year+"/"+month+"/"+all+"/"+null+"/"+null+"/"+null+"/"+subcounty);
					}
				}
			});
		});
	}
	// Year/Month filter handler
</script>