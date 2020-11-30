<script type="text/javascript">
	$().ready(function () {
		localStorage.setItem("my_var", 0);
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
	        	var all = localStorage.getItem("my_var");
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
					// fetching the partner outcomes
					$("#agency_div").html("<center><div class='loader'></div></center>");
					$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>");
	        	} else {
	        		$("#first").hide();
	        		$("#second").show();
	        		
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#justification").html("<center><div class='loader'></div></center>");
					$("#partners").html("<center><div class='loader'></div></center>");
					$("#partners_current_suppression").html("<center><div class='loader'></div></center>");

	        		$("#samples").load("<?php echo base_url('charts/agencies/sample_types'); ?>/"+null+"/"+null+"/"+data+"/"+all);
	        		$("#vlOutcomes").load("<?= @base_url('charts/agencies/vl_outcomes');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        		$("#gender").load("<?= @base_url('charts/agencies/gender');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        		$("#ageGroups").load("<?= @base_url('charts/agencies/age');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        		$("#justification").load("<?= @base_url('charts/agencies/justification');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
	        		$("#partners").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+1+"/"+data);
	        		$("#partners_current_suppression").load("<?= @base_url('charts/agencies/current_suppression'); ?>/"+data);
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
			    $.get("<?php echo base_url();?>partner/check_agencies_select", function (data) {
					agency = data;
					agency = $.parseJSON(agency);
					
					if (agency==0) {
						$("#second").hide();
						$("#third").hide();
						// fetching the Agencies outcomes
						$("#agency_div").html("<center><div class='loader'></div></center>");
						$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
		        		$("#first").hide();
		        		$("#second").show();
						$("#samples").html("<center><div class='loader'></div></center>");
						$("#vlOutcomes").html("<center><div class='loader'></div></center>");
						$("#gender").html("<center><div class='loader'></div></center>");
						$("#ageGroups").html("<center><div class='loader'></div></center>");
						$("#justification").html("<center><div class='loader'></div></center>");
						
		        		$("#samples").load("<?php echo base_url('charts/agencies/sample_types'); ?>/"+null+"/"+null+"/"+agency+"/"+all);
		        		$("#vlOutcomes").load("<?= @base_url('charts/agencies/vl_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+agency);
		        		$("#gender").load("<?= @base_url('charts/agencies/gender');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+agency);
		        		$("#ageGroups").load("<?= @base_url('charts/agencies/age');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+agency);
		        		$("#justification").load("<?= @base_url('charts/agencies/justification');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+null+"/"+agency);
	        			$("#partners").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+1+"/"+agency);				
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
			
			$.get("<?php echo base_url();?>partner/check_agencies_select", function (data) {
				agency = data;
				agency = $.parseJSON(agency);
				
				if (agency==0) {
					$("#second").hide();
					// fetching the partner outcomes
					$("#agency_div").html("<center><div class='loader'></div></center>");
					$("#agency_div").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+year+"/"+month);
				} else {
	        		$("#first").hide();
	        		$("#second").show();
	        		
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#justification").html("<center><div class='loader'></div></center>");
					
	        		$("#samples").load("<?php echo base_url('charts/agencies/sample_types'); ?>/"+year+"/"+null+"/"+agency+"/"+all);
	        		$("#vlOutcomes").load("<?= @base_url('charts/agencies/vl_outcomes');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+agency);
	        		$("#gender").load("<?= @base_url('charts/agencies/gender');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+agency);
	        		$("#ageGroups").load("<?= @base_url('charts/agencies/age');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+agency);
	        		$("#justification").load("<?= @base_url('charts/agencies/justification');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+agency);
	        		$("#partners").load("<?php echo base_url('charts/agencies/suppression'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+1+"/"+agency);	
				}
			});
		});
	}

	function switch_source(){
		var all = localStorage.getItem("my_var");

		if(all == 0){
			localStorage.setItem("my_var", 1);
			all=1;
			$("#samples_heading").html('Testing Trends for All Tests');
			$("#switchButton").val('Click to Switch to Routine Tests Trend');

		}
		else{
			localStorage.setItem("my_var", 0);
			all=0;
			$("#samples_heading").html('Testing Trends for Routine VL');
			$("#switchButton").val('Click to Switch to All Tests');
		}
		$("#samples").load("<?php echo base_url('charts/agencies/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+all);

	}
</script>