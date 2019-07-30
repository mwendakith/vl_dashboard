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

		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>");

		$("#age").change(function(){
			em = $(this).val();
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_age_category_data", { age_cat: em } );
	     
	   // //      // Put the results in a div
	        posting.done(function( response ) {
	      	console.log(response);
	   // //      	$.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
	   // //      		$("#breadcrum").html(data);
	   // //      	});
	        	$.get("<?php echo base_url();?>template/dates", function(data2){
	        		obj = $.parseJSON(data2);
			
					if(obj['month'] == "null" || obj['month'] == null){
						obj['month'] = "";
					}
					$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	        	});

	        	if (response == null || response == 'null' || response == '') {
	        		$("#second").hide();
	        		$("#first").show();

	        		$("#age_outcomes").html("<center><div class='loader'></div></center>");
	        		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>");
	        	} else {
	        		response = JSON.parse(response);
	        		var age = "";
	        		for (i = 0; i < response.length; i++) { 
					    age += "." + response[i];
					}
	        		
	        		$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#county").html("<center><div class='loader'></div></center>");
					$("#countiesAge").html("<center><div class='loader'></div></center>");
					$("#partnersAge").html("<center><div class='loader'></div></center>");
					$("#facilitiesAge").html("<center><div class='loader'></div></center>");
					$("#subcountiesAge").html("<center><div class='loader'></div></center>");
					$("#regimen_age").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/ages/age_vl_outcome'); ?>");
					$("#gender").load("<?php echo base_url('charts/ages/age_gender'); ?>/"+null+"/"+null+"/"+age); 
					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+7+"/"+age);
					$("#county").load("<?php echo base_url('charts/ages/age_county_outcomes'); ?>/"+null+"/"+null+"/"+age);
					$("#countiesAge").load("<?= @base_url('charts/ages/age_breakdowns'); ?>/"+null+"/"+null+"/"+age+"/"+null+"/"+null+"/"+1);
					$("#partnersAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+null+"/"+null+"/"+age+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#facilitiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+null+"/"+null+"/"+age+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#subcountiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+null+"/"+null+"/"+age+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#regimen_age").load("<?= @base_url('charts/ages/age_regimen'); ?>/"+null+"/"+null+"/"+age+"/"+null+"/"+null);
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
		    
		    if (!error_check) {
			    $.get("<?php echo base_url('age/check_age_select');?>", function( data ){
					data = $.parseJSON(data);
					if (data==0) {
						$("#second").hide();
		        		$("#first").show();

		        		$("#age_outcomes").html("<center><div class='loader'></div></center>");
		        		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
					} else {
						var age = "";
		        		for (i = 0; i < data.length; i++) { 
						    age += "." + data[i];
						}
						$("#first").hide();
		        		$("#second").show();

		        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
						$("#gender").html("<center><div class='loader'></div></center>");
						$("#samples").html("<center><div class='loader'></div></center>");
						$("#county").html("<center><div class='loader'></div></center>");
						$("#countiesAge").html("<center><div class='loader'></div></center>");
						$("#partnersAge").html("<center><div class='loader'></div></center>");
						$("#facilitiesAge").html("<center><div class='loader'></div></center>");
						$("#subcountiesAge").html("<center><div class='loader'></div></center>");
						$("#regimen_age").html("<center><div class='loader'></div></center>");
						
						$("#vlOutcomes").load("<?php echo base_url('charts/ages/age_vl_outcome'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]);
						$("#gender").load("<?php echo base_url('charts/ages/age_gender'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]); 
						$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+7+"/"+age);
						$("#county").load("<?php echo base_url('charts/ages/age_county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]);
						$("#countiesAge").load("<?= @base_url('charts/ages/age_breakdowns'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]+"/"+1);
						$("#partnersAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]+"/"+null+"/"+1);
						$("#facilitiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+null+"/"+1);
						$("#subcountiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]+"/"+null+"/"+null+"/"+1);
						$("#regimen_age").load("<?= @base_url('charts/ages/age_regimen'); ?>/"+from[1]+"/"+from[0]+"/"+age+"/"+to[1]+"/"+to[0]);
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

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");

			$.get("<?php echo base_url('age/check_age_select');?>", function( data ){
				data = $.parseJSON(data);
				if (data==0) {
					$("#second").hide();
	        		$("#first").show();

	        		$("#age_outcomes").html("<center><div class='loader'></div></center>");
	        		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>/"+year+"/"+month);
				} else {
					var age = "";
	        		for (i = 0; i < data.length; i++) { 
					    age += "." + data[i];
					}
					console.log(age);
					$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					$("#county").html("<center><div class='loader'></div></center>");
					$("#countiesAge").html("<center><div class='loader'></div></center>");
					$("#partnersAge").html("<center><div class='loader'></div></center>");
					$("#facilitiesAge").html("<center><div class='loader'></div></center>");
					$("#subcountiesAge").html("<center><div class='loader'></div></center>");
					$("#regimen_age").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/ages/age_vl_outcome'); ?>/"+year+"/"+month+"/"+age);
					$("#gender").load("<?php echo base_url('charts/ages/age_gender'); ?>/"+year+"/"+month+"/"+age); 
					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+7+"/"+age);
					$("#county").load("<?php echo base_url('charts/ages/age_county_outcomes'); ?>/"+year+"/"+month+"/"+age);
					$("#countiesAge").load("<?= @base_url('charts/ages/age_breakdowns'); ?>/"+year+"/"+month+"/"+age+"/"+null+"/"+null+"/"+1);
					$("#partnersAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+year+"/"+month+"/"+age+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#facilitiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+year+"/"+month+"/"+age+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#subcountiesAge").load("<?php echo base_url('charts/ages/age_breakdowns'); ?>/"+year+"/"+month+"/"+age+"/"+null+"/"+null+"/"+null+"/"+null+"/"+1);
					$("#regimen_age").load("<?= @base_url('charts/ages/age_regimen'); ?>/"+year+"/"+month+"/"+age);
				}
			});
			
		}); 
	}
</script>