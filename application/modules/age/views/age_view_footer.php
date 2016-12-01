<script type="text/javascript">
	$().ready(function(){
		$("#second").hide();

		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>");

		$("select").change(function(){
			em = $(this).val();
			// console.log(em);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_age_category_data", { age_cat: em } );
	     
	   //      // Put the results in a div
	        posting.done(function( data ) {
	        	// console.log(data);
	   //      	$.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
	   //      		$("#breadcrum").html(data);
	   //      	});
	        	$.get("<?php echo base_url();?>template/dates", function(data){
	        		obj = $.parseJSON(data);
			
					if(obj['month'] == "null" || obj['month'] == null){
						obj['month'] = "";
					}
					$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	        	});
	        	if (data=="") {
	        		$("#second").hide();
	        		$("#first").show();

	        		$("#age_outcomes").load("<?php echo base_url('charts/ages/age_outcomes');?>");
	        	} else {
	        		$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/ages/age_vl_outcome'); ?>");
					$("#gender").load("<?php echo base_url('charts/ages/age_gender'); ?>/"+null+"/"+null+"/"+data); 
					$("#samples").load("<?php echo base_url('charts/ages/sample_types'); ?>/"+null+"/"+data);
	        	}      	
	        });
	    });
	});
</script>