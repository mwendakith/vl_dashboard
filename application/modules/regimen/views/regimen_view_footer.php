<script type="text/javascript">
	$().ready(function () {
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$("#second").hide();

		$("#regimen_outcomes").load("<?php echo base_url('charts/regimen/regimen_outcomes');?>");


		$("select").change(function(){
			em = $(this).val();
			// console.log(em);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_regimen_data", { regimen: em } );
	     
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

	        		$("#regimen_outcomes").load("<?php echo base_url('charts/regimen/regimen_outcomes');?>");
	        	} else {
	        		$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#age").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/regimen/regimen_vl_outcome'); ?>");
					$("#gender").load("<?php echo base_url('charts/regimen/regimen_gender'); ?>/"+null+"/"+null+"/"+data);
					$("#age").load("<?php echo base_url('charts/regimen/regimen_age'); ?>/"+null+"/"+null+"/"+data); 
					$("#samples").load("<?php echo base_url('charts/regimen/sample_types'); ?>/"+null+"/"+data);
	        	}      	
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

			$.get("<?php echo base_url('regimen/check_regimen_select');?>", function( data ){
				data = $.parseJSON(data);
				if (data==0) {
					$("#second").hide();
	        		$("#first").show();

	        		$("#regimen_outcomes").load("<?php echo base_url('charts/regimen/regimen_outcomes');?>/"+year+"/"+month);
				} else {
					$("#first").hide();
	        		$("#second").show();

	        		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#age").html("<center><div class='loader'></div></center>");
					$("#samples").html("<center><div class='loader'></div></center>");
					
					$("#vlOutcomes").load("<?php echo base_url('charts/regimen/regimen_vl_outcome'); ?>/"+year+"/"+month+"/"+data);
					$("#gender").load("<?php echo base_url('charts/regimen/regimen_gender'); ?>/"+year+"/"+month+"/"+data);
					$("#age").load("<?php echo base_url('charts/regimen/regimen_age'); ?>/"+year+"/"+month+"/"+data); 
					$("#samples").load("<?php echo base_url('charts/regimen/sample_types'); ?>/"+year+"/"+data);
				}
			});
			
		}); 
	}
</script>