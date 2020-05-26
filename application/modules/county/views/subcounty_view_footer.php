<script type="text/javascript">
	$().ready(function () {
		localStorage.setItem("my_var", 0);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#second").hide();
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+1, function(data){
			// console.log(data);
	        	$("#breadcrum").html(data);
	       });
		$("#regimen_outcomes").load("<?php echo base_url('charts/subcounties/subcounty_outcomes');?>");
		$("#subcounty_summary").load("<?php echo base_url('charts/subcounties/subcounties_table');?>");
		$("#subcounty_outcome_age_gender").load("<?php echo base_url('charts/subcounties/subcounty_outcome_table');?>");


		$("select").change(function(){
			em = $(this).val();
			// console.log(em);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_sub_county_data", { subCounty: em } );
	        var all = localStorage.getItem("my_var");
	     
	   //      // Put the results in a div
	        posting.done(function( subcounty ) {
	        	if (subcounty==null||subcounty=='null'||subcounty==undefined||subcounty=='') {
	        		subcounty = null
	        	}
	        	// console.log(subcounty);
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
	        		$("#second").hide();
	        		$("#first").show();

	        		$("#regimen_outcomes").load("<?php echo base_url('charts/subcounties/subcounty_outcomes');?>");
					$("#subcounty_summary").load("<?php echo base_url('charts/subcounties/subcounties_table');?>");
					$("#subcounty_outcome_age_gender").load("<?php echo base_url('charts/subcounties/subcounty_outcome_table');?>");
	        	} else {
	        		subcounty = JSON.parse(subcounty);
	        		$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#age").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#sub_counties").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/subcounties/subcounty_vl_outcomes'); ?>/"+null+"/"+null+"/"+subcounty);
					$("#gender").load("<?php echo base_url('charts/subcounties/subcounty_gender'); ?>/"+null+"/"+null+"/"+subcounty);
					$("#age").load("<?php echo base_url('charts/subcounties/subcounty_age'); ?>/"+null+"/"+null+"/"+subcounty); 
					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2+"/"+subcounty+"/"+all);
					$("#sub_counties").load("<?php echo base_url('charts/subcounties/subcounty_sites'); ?>/"+null+"/"+null+"/"+subcounty);
					$("#long_tracking").load("<?php echo base_url('charts/subcounties/get_patients'); ?>/"+null+"/"+null+"/"+subcounty);
					$("#current_sup_dynamic").load("<?php echo base_url('charts/subcounties/get_current_suppresion'); ?>/"+null+"/"+null+"/"+subcounty);

	        	}      	
	        });
	    });

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
		    var all = localStorage.getItem("my_var");
		    
		    if (!error_check) {
			    $.get("<?php echo base_url('county/check_subcounty_select');?>", function( data ){
					data = $.parseJSON(data);
					if (data==0) {
						$("#second").hide();
		        		$("#first").show();

		        		$("#regimen_outcomes").load("<?php echo base_url('charts/subcounties/subcounty_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
						$("#subcounty_summary").load("<?php echo base_url('charts/subcounties/subcounties_table');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
						$("#subcounty_outcome_age_gender").load("<?php echo base_url('charts/subcounties/subcounty_outcome_table');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						$("#first").hide();
		        		$("#second").show();

		        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
						$("#gender").html("<center><div class='loader'></div></center>");
						$("#age").html("<center><div class='loader'></div></center>");
						$("#samples").html("<center><div class='loader'></div></center>");
						$("#subcounties").html("<center><div class='loader'></div></center>");
						
						$("#vlOutcomes").load("<?php echo base_url('charts/subcounties/subcounty_vl_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]);
						$("#gender").load("<?php echo base_url('charts/subcounties/subcounty_gender'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]);
						$("#age").load("<?php echo base_url('charts/subcounties/subcounty_age'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]); 
						$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+2+"/"+data+"/"+all);
						$("#subcounties").load("<?php echo base_url('charts/subcounties/subcounty_sites'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]); 
						$("#long_tracking").load("<?php echo base_url('charts/subcounties/get_patients'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]); 
						$("#current_sup_dynamic").load("<?php echo base_url('charts/subcounties/get_current_suppresion'); ?>/"+from[1]+"/"+from[0]+"/"+data+"/"+to[1]+"/"+to[0]); 
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
 		// console.log(year+"<___>"+month);
 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );
 		var all = localStorage.getItem("my_var");

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");

			$.get("<?php echo base_url('county/check_subcounty_select');?>", function( data ){
				data = $.parseJSON(data);
				if (data==0) {
					$("#second").hide();
	        		$("#first").show();

	        		$("#regimen_outcomes").load("<?php echo base_url('charts/subcounties/subcounty_outcomes');?>/"+year+"/"+month);
					$("#subcounty_summary").load("<?php echo base_url('charts/subcounties/subcounties_table');?>/"+year+"/"+month);
					$("#subcounty_outcome_age_gender").load("<?php echo base_url('charts/subcounties/subcounty_outcome_table');?>/"+year+"/"+month);
				} else {
					$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#age").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#subcounties").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/subcounties/subcounty_vl_outcomes'); ?>/"+year+"/"+month+"/"+data);
					$("#gender").load("<?php echo base_url('charts/subcounties/subcounty_gender'); ?>/"+year+"/"+month+"/"+data);
					$("#age").load("<?php echo base_url('charts/subcounties/subcounty_age'); ?>/"+year+"/"+month+"/"+data); 
					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+2+"/"+data+"/"+all);
					$("#subcounties").load("<?php echo base_url('charts/subcounties/subcounty_sites'); ?>/"+year+"/"+month+"/"+data); 
					$("#long_tracking").load("<?php echo base_url('charts/subcounties/get_patients'); ?>/"+year+"/"+month+"/"+data); 
					$("#current_sup_dynamic").load("<?php echo base_url('charts/subcounties/get_current_suppresion'); ?>/"+year+"/"+month+"/"+data); 
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

		}
		else{
			localStorage.setItem("my_var", 0);
			all=0;
			$("#samples_heading").html('Testing Trends for Routine VL');
		}
		$.get("<?php echo base_url();?>county/check_subcounty_select", function (data) {
			data = $.parseJSON(data);
			if(data == 0){data = null;}
			$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2+"/"+data+"/"+all);
		});
	}
</script>