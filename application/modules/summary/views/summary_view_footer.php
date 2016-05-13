<script type="text/javascript">
	$().ready(function(){
		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>"); 
		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>");
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>"); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>"); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>");
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>");

		$(".display_date").load("<?php echo base_url('charts/summaries/display_date'); ?>");
		$(".display_range").load("<?php echo base_url('charts/summaries/display_range'); ?>");

		$('#filter_form').submit(function( event ) {
         
	        // Stop form from submitting normally
	        event.preventDefault();
	        
	        // Get some values from elements on the page:
	        var $form = $( this ),
	        em = $form.find( "select[name='county']" ).val(),
	        url = $form.attr( "action" );
	        
	        // Send the data using post
	        var posting = $.post( url, { county: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	          // console.log(data);
	        });
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
 		
 		
 		$("#county").html("<div>Loading...</div>"); 
		$("#vlOutcomes").html("<div>Loading...</div>");
		$("#justification").html("<div>Loading...</div>");
		$("#ageGroups").html("<div>Loading...</div>");
		$("#gender").html("<div>Loading...</div>");
		$("#samples").html("<div>Loading...</div>");

 		$("#county").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month); 
		$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month);
		$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month); 
		$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month); 
		$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month);
		$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year);
	}
	
</script>