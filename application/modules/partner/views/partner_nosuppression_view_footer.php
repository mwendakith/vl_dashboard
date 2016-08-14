<script type="text/javascript">
	$().ready(function() {
		$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+null+"/"+null+"/"+null+"/"+1);
 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+null+"/"+null+"/"+null+"/"+1);
		$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+null+"/"+null+"/"+null+"/"+1);
		$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+null+"/"+null+"/"+null+"/"+1);
		$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+null+"/"+null+"/"+null+"/"+1);

		$(".display_date").load("<?php echo base_url('charts/nonsuppression/display_date'); ?>");

		$("select").change(function(){
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
					
	        	});

	        	$("#genderGrp").html("<div>Loading...</div>"); 
	        	$("#ageGrp").html("<div>Loading...</div>"); 
				$("#justification").html("<div>Loading...</div>");
				$("#regimen").html("<div>Loading...</div>");
				$("#sampleType").html("<div>Loading...</div>");
				
				$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+null+"/"+null+"/"+null+"/"+data);
		 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+null+"/"+null+"/"+null+"/"+data);
				$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+null+"/"+null+"/"+null+"/"+data);
				
	        });
		});

		// $('#filter_form').submit(function( event ) {
         
	 //        // Stop form from submitting normally
	 //        event.preventDefault();
	        
	 //        // Get some values from elements on the page:
	 //        var $form = $( this ),
	 //        em = $form.find( "select[name='partner']" ).val(),
	 //        url = $form.attr( "action" );
	        
	 //        // Send the data using post
	 //        var posting = $.post( url, { county: em } );
	     
	 //        // Put the results in a div
	 //        posting.done(function( data ) {
	 //          	$.get("<?php echo base_url();?>template/breadcrum/"+1, function(data){
	 //        		$("#breadcrum").html(data);
	 //        	});
	 //        	$.get("<?php echo base_url();?>template/dates", function(data){
	 //        		obj = $.parseJSON(data);
			
		// 			if(obj['month'] == "null" || obj['month'] == null){
		// 				obj['month'] = "";
		// 			}
		// 			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					
	 //        	});

	 //        	$("#genderGrp").html("<div>Loading...</div>"); 
	 //        	$("#ageGrp").html("<div>Loading...</div>"); 
		// 		$("#justification").html("<div>Loading...</div>");
		// 		$("#regimen").html("<div>Loading...</div>");
		// 		$("#sampleType").html("<div>Loading...</div>");
				
		// 		$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+null+"/"+null+"/"+null+"/"+data);
		//  		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+null+"/"+null+"/"+null+"/"+data);
		// 		$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+null+"/"+null+"/"+null+"/"+data);
		// 		$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+null+"/"+null+"/"+null+"/"+data);
		// 		$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+null+"/"+null+"/"+null+"/"+data);
				
	 //        });
  //   	});
	});

	function date_filter(criteria, id)
 	{
 		$("#genderGrp").html("<div>Loading...</div>"); 
        $("#ageGrp").html("<div>Loading...</div>"); 
		$("#justification").html("<div>Loading...</div>");
		$("#regimen").html("<div>Loading...</div>");
		$("#sampleType").html("<div>Loading...</div>");

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
 		$.get("<?php echo base_url('partner/get_selected_partner')?>", function(partner) {
	 		$("#genderGrp").load("<?php echo base_url('charts/nonsuppression/gender_group');?>/"+year+"/"+month+"/"+null+"/"+partner);
	 		$("#ageGrp").load("<?php echo base_url('charts/nonsuppression/age_group');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#justification").load("<?php echo base_url('charts/nonsuppression/justification');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#regimen").load("<?php echo base_url('charts/nonsuppression/regimen');?>/"+year+"/"+month+"/"+null+"/"+partner);
			$("#sampleType").load("<?php echo base_url('charts/nonsuppression/sample_type');?>/"+year+"/"+month+"/"+null+"/"+partner);
		});
	}
</script>