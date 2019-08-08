<script type="text/javascript">
	$().ready(function(){
		sessionStorage.setItem("region", 0);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
    	});

    	$("#first").show();
		$("#second").hide();

		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
		
		$("select").change(function(){
			em = $(this).val();
			if(em == 48)
				sessionStorage.setItem("region", 0);
			else
				sessionStorage.setItem("region", em);
			var county = sessionStorage.getItem("region")
	        	// alert(county);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+county, function(data){
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

	        	// alert(data);
	        	//

	        	if(county == 0){

	        		$("#first").show();
					$("#second").hide();

					$('#heading').html('Counties Outcomes <div class="display_date"></div>');

	        		$("#county").html("<center><div class='loader'></div></center>");
					$("#county").load("<?php echo base_url('charts/summaries/county_outcomes');?>");
	        	}
	        	else{
	        		$("#second").show();
					$("#first").hide();

					// $("#county_sites").empty();

					$('#heading').html('County Partners Outcomes <div class="display_date"></div>');

					$("#county_partners").html("<center><div class='loader'></div></center>");
					$("#county_partners").load("<?php echo base_url('charts/summaries/county_partner_outcomes');?>/"+null+"/"+null+"/"+null+"/"+county);

					$("#partners").html("<center><div class='loader'></div></center>");
					$("#partners").load("<?php echo base_url('charts/summaries/county_partner_table');?>/"+null+"/"+null+"/"+null+"/"+null+"/"+county);
					

	        	}
		});
		$("button").click(function () {
			var county = sessionStorage.getItem("region");
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    console.log('show'+first);
		    console.log('show'+second);
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    if (!error_check) {
					//Checking if county was previously selected and calling the relevant views
					if (county==0) {
						$("#first").show();
						$("#second").hide();

						$('#heading').html('Counties Outcomes <div class="display_date"></div>');

						$("#county").html("<center><div class='loader'></div></center>"); 
		 				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);

					} else {
						$("#second").show();
						$("#first").hide();

						$('#heading').html('County Partners Outcomes <div class="display_date"></div>');

						$("#county_partners").html("<center><div class='loader'></div></center>"); 
		 				$("#county_partners").load("<?php echo base_url('charts/summaries/county_partner_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+county+"/"+to[1]+"/"+to[0]);

		 				$("#partners").html("<center><div class='loader'></div></center>"); 
		 				$("#partners").load("<?php echo base_url('charts/summaries/county_partner_table'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+county);
				
					}
			}
		    
		});
	});
	function date_filter(criteria, id)
	 	{
	 		var county = sessionStorage.getItem("region")
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
				
					//Checking if county was previously selected and calling the relevant views
					if (county==0) {
						$("#first").show();
						$("#second").hide();

						$('#heading').html('Counties Outcomes <div class="display_date"></div>');

						$("#county").html("<center><div class='loader'></div></center>"); 
		 				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month);

					} else {
						$("#second").show();
						$("#first").hide();

						$('#heading').html('Sub-Counties Outcomes <div class="display_date"></div>');

						$("#county_partners").html("<center><div class='loader'></div></center>"); 
		 				$("#county_partners").load("<?php echo base_url('charts/summaries/county_partner_outcomes'); ?>/"+year+"/"+month+"/"+null+"/"+county);

		 				$("#partners").html("<center><div class='loader'></div></center>"); 
		 				$("#partners").load("<?php echo base_url('charts/summaries/county_partner_table'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+county);
					}
			});
		}
</script>