<script type="text/javascript">
	$().ready(function(){
		localStorage.setItem("my_var", 1);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		$.get("<?php echo base_url();?>template/breadcrum/"+null+"/"+null+"/"+null+"/"+1, function(data){
			// console.log(data);
	        	$("#breadcrum").html(data);
	       });
		$("#subcounty_tat_outcomes").load("<?= @base_url('charts/tat/outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2);
		$("#subcounty_tat_details").load("<?= @base_url('charts/tat/details'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2);

		//Function when the county is selected
		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_sub_county_data", { subCounty: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
	        	if (data == ""){
	        		data = null;
	        	}
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+null+"/"+null+"/"+1, function(data){
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
	        	
	        	if (data ==  '' || data==null) {
	        		// Loader displaying
		        	$("#subcounty_tat_outcomes").html("<center><div class='loader'></div></center>");
		        	$("#subcounty_tat_details").html("<center><div class='loader'></div></center>");

					$("#subcounty_tat_outcomes").load("<?= @base_url('charts/tat/outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2);
					$("#subcounty_tat_details").load("<?= @base_url('charts/tat/details'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2);
	        	} else {
	        		// Loader displaying
		        	$("#subcounty_tat_outcomes").html("<center><div class='loader'></div></center>");
		        	$("#subcounty_tat_details").html("<center><div class='loader'></div></center>");

					$("#subcounty_tat_outcomes").load("<?= @base_url('charts/tat/outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2+"/"+data);
					$("#subcounty_tat_details").load("<?= @base_url('charts/tat/details'); ?>/"+null+"/"+null+"/"+null+"/"+null+"/"+2+"/"+data);
	        	}
	        	 
	        });
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
			    $("#subcounty_tat_outcomes").html("<center><div class='loader'></div></center>");
			    $("#subcounty_tat_details").html("<center><div class='loader'></div></center>");
		        
				$("#subcounty_tat_outcomes").load("<?= @base_url('charts/tat/outcomes'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+2);
				$("#subcounty_tat_details").load("<?= @base_url('charts/tat/details'); ?>/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]+"/"+2);
			}
		    
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
 		
		var all = localStorage.getItem("my_var");

 		// Put the results in a div
		posting.done(function( data ) {
			obj = $.parseJSON(data);
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
		});
 		$("#subcounty_tat_outcomes").html("<center><div class='loader'></div></center>");
 		$("#subcounty_tat_details").html("<center><div class='loader'></div></center>");
    	
		$("#subcounty_tat_outcomes").load("<?= @base_url('charts/tat/outcomes');?>/"+year+"/"+month+"/"+null+"/"+null+"/"+2);
		$("#subcounty_tat_details").load("<?= @base_url('charts/tat/details'); ?>/"+year+"/"+month+"/"+null+"/"+null+"/"+2); 
	}
</script>