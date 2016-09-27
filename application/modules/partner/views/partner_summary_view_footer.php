<script type="text/javascript">
	$().ready(function () {
		var partner = <?php echo json_encode($partner_select);?>;
		console.log(partner);
		if (partner) {
			console.log('We have selected a partner!');
		} else {
			console.log('I can neither confirm or deny the allegations!');
			$("#second").hide();
			$("#third").hide();
			// fetching the partner outcomes
			$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
		}

		// fetching the data for a specific partner
		$("select").change(function(){
			part = $(this).val();
			console.log(part);
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: part } );
	        
	        // Put the results in a div
	        posting.done(function( data ) {
	        	console.log(data);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		$("#breadcrum").html(data);
	        	});

	        	// Condition to dispay the proper divs based on whether a partner is selected or not
	        	if (data=='null') {
	        		console.log('I can neither confirm or deny the allegations!');
	        		$("#second").hide();
					$("#third").hide();
					// fetching the partner outcomes
					$("#partner").html("<center><div class='loader'></div></center>");
					$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
	        	} else {
	        		console.log('We have selected a partner!');
	        	}
	        });
		});
	});

	function date_filter(criteria, id)
	{
		console.log(criteria+"::"+id);
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
			
			$.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
				partner = data;
				console.log(partner);
				if (partner==0) {
					console.log('I can neither confirm or deny the allegations!');
					$("#second").hide();
					$("#third").hide();
					// fetching the partner outcomes
					$("#partner").html("<center><div class='loader'></div></center>");
					$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1);
				} else {
					console.log('We have selected a partner!');
				}
			});
			
			// if (partner===0) {

			// } else {
			// 	$("#second").hide();
			// 	$("#third").hide();

			// 	$("#partner").html("<center><div class='loader'></div></center>");
			// 	$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1);
			// }
			
		});
	}

	// $().ready(function(){
	// 	$.get("<?php echo base_url('partner/check_partner_select');?>", function(partner) {
	// 		// console.log(partner);
	// 		if (partner==0) {
	// 			$("#second").hide();
	// 			$("#third").hide();

	// 			$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
	// 		} else {
	// 			$("#second").show();
	// 			$("#third").show();

	// 			$("#vlOutcomes").html("<center><div class='loader'></div></center>");
	// 			$("#justification").html("<center><div class='loader'></div></center>");
	// 			$("#ageGroups").html("<center><div class='loader'></div></center>");
	// 			$("#gender").html("<center><div class='loader'></div></center>");
	// 			$("#samples").html("<center><div class='loader'></div></center>");
	// 			$("#partner").html("<center><div class='loader'></div></center>");
	// 	        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
	// 			$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+partner);
	// 			$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+partner);
	// 			$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+null+"/"+partner);
	// 			$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+null+"/"+partner);
	// 			$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+null+"/"+partner);
	// 			$("#partner").load("<?php echo base_url('charts/sites/site_outcomes'); ?>/"+null+"/"+null+"/"+partner);
	// 		}
	// 	});
		
	// 	$("select").change(function(){
	// 		$("#partner").html("<div>Loading...</div>");
	// 		em = $(this).val();

	// 		// Send the data using post
	//         var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	        
	//         // Put the results in a div
	//         posting.done(function( data ) {
	        	
	//         	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		
	//         		$("#breadcrum").html(data);
	//         	});
	//         	$.get("<?php echo base_url();?>template/dates", function(data){
	//         		obj = $.parseJSON(data);
			
	// 				if(obj['month'] == "null" || obj['month'] == null){
	// 					obj['month'] = "";
	// 				}
	// 				$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
	// 				$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	//         	});
	//         		if (em=='NA') {
	// 					$("#second").hide();
	// 					$("#third").hide();

	// 					$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+1);
	// 				} else {
	// 					$("#second").show();
	// 					$("#third").show();

	// 					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
	// 					$("#justification").html("<center><div class='loader'></div></center>");
	// 					$("#ageGroups").html("<center><div class='loader'></div></center>");
	// 					$("#gender").html("<center><div class='loader'></div></center>");
	// 					$("#samples").html("<center><div class='loader'></div></center>");
	// 					$("#partner").html("<center><div class='loader'></div></center>");
	// 			        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
	// 					$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+null+"/"+null+"/"+em);
	// 					$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+null+"/"+null+"/"+null+"/"+em);
	// 					$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+null+"/"+null+"/"+null+"/"+em);
	// 					$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+null+"/"+null+"/"+null+"/"+em);
	// 					$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+null+"/"+null+"/"+null+"/"+em);
	// 					$("#partner").load("<?php echo base_url('charts/sites/site_outcomes'); ?>/"+null+"/"+null+"/"+em);
	// 				}
	// 			});
	// 	});
	// });

	// function date_filter(criteria, id)
 // 	{
 // 		$("#partner").html("<div>Loading...</div>");

 // 		if (criteria === "monthly") {
 // 			year = null;
 // 			month = id;
 // 		}else {
 // 			year = id;
 // 			month = null;
 // 		}

 // 		var posting = $.post( '<?php echo base_url();?>summary/set_filter_date', { 'year': year, 'month': month } );

 // 		// Put the results in a div
	// 	posting.done(function( data ) {
	// 		obj = $.parseJSON(data);
			
	// 		if(obj['month'] == "null" || obj['month'] == null){
	// 			obj['month'] = "";
	// 		}
	// 		$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
	// 		$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
	// 	});
	//  	$.get("<?php echo base_url('partner/check_partner_select');?>", function(partner) {	
	//  		console.log(partner);
	//  		if (partner==0) {
	//  			$("#second").hide();
	// 			$("#third").hide();

	// 			$("#partner").html("<center><div class='loader'></div></center>");
	// 			$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1);
	//  		} else {
	//  			$("#second").show();
	// 			$("#third").show();

	// 			$("#vlOutcomes").html("<center><div class='loader'></div></center>");
	// 			$("#justification").html("<center><div class='loader'></div></center>");
	// 			$("#ageGroups").html("<center><div class='loader'></div></center>");
	// 			$("#gender").html("<center><div class='loader'></div></center>");
	// 			$("#samples").html("<center><div class='loader'></div></center>");
	// 	        // $("#county").load("<?php //echo base_url('charts/summaries/county_outcomes'); ?>/"+null+"/"+null+"/"+data); 
	// 			$("#samples").load("<?php echo base_url('charts/summaries/sample_types'); ?>/"+year+"/"+month+"/"+partner);
	// 			$("#vlOutcomes").load("<?php echo base_url('charts/summaries/vl_outcomes'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
	// 			$("#justification").load("<?php echo base_url('charts/summaries/justification'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
	// 			$("#ageGroups").load("<?php echo base_url('charts/summaries/age'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
	// 			$("#gender").load("<?php echo base_url('charts/summaries/gender'); ?>/"+year+"/"+month+"/"+null+"/"+partner);
	// 			$("#partner").load("<?php echo base_url('charts/summaries/county_outcomes'); ?>/"+year+"/"+month+"/"+1+"/"+partner);
	//  		}
	//  	});
 // 	}

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