<script type="text/javascript">
	$().ready(function(){
		nat = true;
		localStorage.setItem("my_var", 0);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
			// console.log(obj);
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+nat);
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>");
		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>");
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>"); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>"); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>");
		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>");
		$("#coverage").load("<?php echo base_url('charts/summaries/vl_coverage'); ?>"); 
		
		$(".display_date").load("<?php echo base_url('charts/summaries/display_date'); ?>");
		$(".display_range").load("<?php echo base_url('charts/summaries/display_range'); ?>");

		$("select").change(function(){
			em = $(this).val();
			var all = localStorage.getItem("my_var");
			localStorage.setItem("county_filter", em);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: em } );
	 
	        // Put the results in a div
	        posting.done(function( data ) {
	        	if(data!=""){
	        		data = JSON.parse(data);
	        	}
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
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

	        	var county = localStorage.getItem("county_filter");
	        	// alert(data);
	        	$('#heading').html('County Sites Outcomes <div class="display_date"></div>');
	        	$("#nattat").html("<div>Loading...</div>");
	        	$("#coverage").html("<div>Loading...</div>");
	        	$("#samples").html("<center><div class='loader'></div></center>");
		        $("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
				
				$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+nat);
				if (!(county==48 || county == '48')) {
					type = 1;
				} else {
					type = 0;
				}		
				$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+type+"/"+county+"/"+all);
				$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+county); 
				$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+county); 
				$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+county); 
				$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+county);
				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+county);
				$("#coverage").load("<?php echo base_url('charts/summaries/vl_coverage'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+type+"/"+county);	
	        });
		});

		$("button").click(function () {
		    var first, second;
		    first = $(".date-picker[name=startDate]").val();
		    second = $(".date-picker[name=endDate]").val();
		    var all = localStorage.getItem("my_var");
		    
		    var new_title = set_multiple_date(first, second);

		    $(".display_date").html(new_title);
		    
		    from = format_date(first);
		    /* from is an array
		     	[0] => month
		     	[1] => year*/
		    to 	= format_date(second);
		    var error_check = check_error_date_range(from, to);
		    
		    if (!error_check) {
		    	$.get("<?php echo base_url();?>county/check_county_select", function (data) {
		    		county = JSON.parse(data);
		    		type = 1;
			    	if (county == 0)
			    		type = 0;
		    		$("#nattat").html("<div>Loading...</div>");
	        		$("#coverage").html("<div>Loading...</div>");
			 		$("#samples").html("<center><div class='loader'></div></center>"); 
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#justification").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
			 		$("#county").html("<center><div class='loader'></div></center>");


					$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+from[1]+"/"+from[0]+"/"+county+"/"+to[1]+"/"+to[0]+"/"+nat);
					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+type+"/"+county+"/"+all);
			 		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]);
					$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]); 
					$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]); 
					$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]);
					$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+null+"/"+to[1]+"/"+to[0]);
					$("#coverage").load("<?php echo base_url('charts/summaries/vl_coverage'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+type+"/"+county);
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
			$.get("<?php echo base_url();?>county/check_county_select", function (data) {
		    	county = JSON.parse(data);
		    	type = 1;
		    	if (county == 0)
		    		type = 0;
				$("#nattat").html("<div>Loading...</div>");
	        	$("#coverage").html("<div>Loading...</div>");
		 		$("#samples").html("<center><div class='loader'></div></center>"); 
				$("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
		 		$("#county").html("<center><div class='loader'></div></center>");

				$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+null+"/"+nat);
				$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+type+"/"+county+"/"+all);
		 		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month);
				$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month); 
				$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month); 
				$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month);
				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month);
				$("#coverage").load("<?php echo base_url('charts/summaries/vl_coverage'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+type+"/"+county);
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
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+null+"/"+all);

	}

	function ageModal()
	{
		$('#agemodal').modal('show');
		$('#CatAge').load('<?php echo base_url();?>charts/summaries/agebreakdown');
		// window.location.reload();
	}

	function justificationModal()
	{
		// alert('Why are you not working!');
		$('#justificationmodal').modal('show');
		$('#CatJust').load('<?php echo base_url();?>charts/summaries/justificationbreakdown');
	}
	
</script>