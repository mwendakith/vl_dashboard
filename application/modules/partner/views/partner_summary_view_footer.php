<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();
		$("#third").hide();

		$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);

		$("select").change(function(){
			$("#partner").html("<div>Loading...</div>");
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	        
	        // Put the results in a div
	        posting.done(function( data ) {
	        	
	        	$.get("<?php echo base_url();?>template/breadcrum/"+1, function(data){
	        		
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
	        	$.get("<?php echo base_url('partner/check_partner_select');?>", function(partner) {	
	 				if (partner) {
			        	$("#second").show();
						$("#third").show();

						$("#vlOutcomes").html("<center><div class='loader'></div></center>");
						$("#justification").html("<center><div class='loader'></div></center>");
						$("#ageGroups").html("<center><div class='loader'></div></center>");
						$("#gender").html("<center><div class='loader'></div></center>");
						$("#samples").html("<center><div class='loader'></div></center>");
				        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
						$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
						$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+data);
					} else {
						$("#second").hide();
						$("#third").hide();

						$("#partner").html("<div>Loading...</div>");
						$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
					}
				});
	        });
		});

		$('#filter_form').submit(function( event ) {
         	$("#partner").html("<div>Loading...</div>");
			
			// Stop form from submitting normally
	        event.preventDefault();
	        
	        // Get some values from elements on the page:
	        var $form = $( this ),
	        em = $form.find( "select[name='partner']" ).val(),
	        url = $form.attr( "action" );
	        
	        // Send the data using post
	        var posting = $.post( url, { partner: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	        	
	        	$.get("<?php echo base_url();?>template/breadcrum/"+1, function(data){
	        		
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
	        	$.get("<?php echo base_url('partner/check_partner_select');?>", function(partner) {	
	 				if (partner) {
			        	$("#second").show();
						$("#third").show();

						$("#vlOutcomes").html("<center><div class='loader'></div></center>");
						$("#justification").html("<center><div class='loader'></div></center>");
						$("#ageGroups").html("<center><div class='loader'></div></center>");
						$("#gender").html("<center><div class='loader'></div></center>");
						$("#samples").html("<center><div class='loader'></div></center>");
				        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
						$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
						$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+null+"/"+data);
						$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+data);
					} else {
						$("#second").hide();
						$("#third").hide();

						$("#partner").html("<div>Loading...</div>");
						$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
					}
				});
	        });
    	});
	});

	function date_filter(criteria, id)
 	{
 		$("#partner").html("<div>Loading...</div>");

 		if (criteria === "monthly") {
 			year = null;
 			month = id;
 		}else {
 			year = id;
 			month = null;
 		}

 		var posting = $.post( '<?php echo base_url();?>summary/set_filter_date', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
	 		
	 	$.get("<?php echo base_url('partner/check_partner_select');?>", function(partner) {	
	 		if (partner) {
	 			$("#second").show();
				$("#third").show();

				$("#vlOutcomes").html("<center><div class='loader'></div></center>");
				$("#justification").html("<center><div class='loader'></div></center>");
				$("#ageGroups").html("<center><div class='loader'></div></center>");
				$("#gender").html("<center><div class='loader'></div></center>");
				$("#samples").html("<center><div class='loader'></div></center>");
		        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
				$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1);
				$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
				$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
				$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
				$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
				$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year+"/"+month+"/"+partner);
	 		} else {
	 			$("#second").hide();
				$("#third").hide();

				$("#partner").html("<center><div class='loader'></div></center>");
				$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1);
	 		}
	 	});
 	}
</script>