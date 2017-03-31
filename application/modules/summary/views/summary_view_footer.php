<script type="text/javascript">
	$().ready(function(){
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
			console.log(obj);
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>");
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>");
		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>");
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>"); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>"); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>");
		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>"); 
		
		$(".display_date").load("<?php echo base_url('charts/summaries/display_date'); ?>");
		$(".display_range").load("<?php echo base_url('charts/summaries/display_range'); ?>");

		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
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

	        	// alert(data);
	        	$('#heading').html('County Sites Outcomes <div class="display_date"></div>');
	        	$("#nattat").html("<div>Loading...</div>");
	        	$("#samples").html("<center><div class='loader'></div></center>");
		        $("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
				
				$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>");
				$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+data);
				$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+data); 
				$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+data); 
				$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+data); 
				$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+data);
				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+data);
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
			    $("#nattat").html("<div>Loading...</div>");
		 		$("#samples").html("<center><div class='loader'></div></center>");
		 		$("#county").html("<center><div class='loader'></div></center>"); 
				$("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");

				$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+to[0]);
				$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+from[1]);
		 		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[0]);
				$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[0]); 
				$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[0]); 
				$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+to[0]);
				$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+null+"/"+null+"/"+null+"/"+to[0]);
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

 		var posting = $.post( '<?php echo base_url();?>template/filter_date_data', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		
		$("#nattat").html("<div>Loading...</div>");
 		$("#samples").html("<center><div class='loader'></div></center>");
 		$("#county").html("<center><div class='loader'></div></center>"); 
		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
		$("#justification").html("<center><div class='loader'></div></center>");
		$("#ageGroups").html("<center><div class='loader'></div></center>");
		$("#gender").html("<center><div class='loader'></div></center>");

		$("#nattat").load("<?php echo base_url('charts/summaries/turnaroundtime'); ?>/"+year+"/"+month);
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year);
 		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month);
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month);
		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month); 
	}

	function ageModal()
	{
		$('#agemodal').modal('show');
		$('#CatAge').load('<?php echo base_url();?>charts/summaries/agebreakdown');
	}

	function justificationModal()
	{
		$('#justificationmodal').modal('show');
		$('#CatJust').load('<?php echo base_url();?>charts/summaries/justificationbreakdown');
	}
	
</script>