<??>
<script type="text/javascript">
	$().ready(function(){
		$("#genderAgeGrp").load("<?php echo base_url('charts/nonsuppression/gender_age_group');?>");
		$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>");
		$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>");
		$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>");

		$(".display_date").load("<?php echo base_url('charts/nonsuppression/display_date'); ?>");

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
	          	$.get("<?php echo base_url();?>template/breadcrum", function(data){
	        		$("#breadcrum").html(data);
	        	});

	        	$("#genderAgeGrp").html("<div>Loading...</div>"); 
				$("#justification").html("<div>Loading...</div>");
				$("#regimen").html("<div>Loading...</div>");
				$("#sampleType").html("<div>Loading...</div>");
				
		 		$("#genderAgeGrp").load("<?php echo base_url('charts/nonsuppression/gender_age_group');?>");
				$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>");
				$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>");
				$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>");
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

 		var posting = $.post( '<?php echo base_url();?>suppression/Nosuppression/set_filter_date', { 'year': year, 'month': month } );

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			
		});
 		
 		
 		$("#genderAgeGrp").html("<div>Loading...</div>"); 
		$("#justification").html("<div>Loading...</div>");
		$("#regimen").html("<div>Loading...</div>");
		$("#sampleType").html("<div>Loading...</div>");
		
 		$("#genderAgeGrp").load("<?php echo base_url('charts/nonsuppression/gender_age_group');?>");
		$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>");
		$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>");
		$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>");
	}
</script>