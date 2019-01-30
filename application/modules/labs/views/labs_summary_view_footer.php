<script type="text/javascript">
	$().ready(function() {

		localStorage.setItem("my_lab", 0);
			
		$("#first").show();
    	$("#second").hide();
    	$("#fourth").hide();
    	$("#fifth").hide();
    	$("#breadcrum").hide();


		$("#lab_perfomance_stats").load("<?= @base_url();?>charts/labs/lab_performance_stats");
		$("#rejected").load("<?= @base_url();?>charts/labs/rejection_trends");
		$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>");
		$("#samples").load("<?php echo base_url();?>charts/labs/sample_types");
		$("#lab_gender").load("<?php echo base_url();?>charts/labs/gender");
		$("#lab_age").load("<?php echo base_url();?>charts/labs/ages");
		$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time");
		$("#results").load("<?php echo base_url();?>charts/labs/results_outcome");

		$("#lab_rejections").load("<?php echo base_url();?>charts/labs/rejections/0");

		$(".display_date").load("<?php echo base_url('charts/labs/display_date'); ?>");

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

				localStorage.setItem("from_year", from[1]);
				localStorage.setItem("from_month", from[0]);

				localStorage.setItem("to_year", to[1]);
				localStorage.setItem("to_month", to[0]);

			    $("#lab_perfomance_stats").html("<div>Loading...</div>"); 
		 		$("#rejected").html("<div>Loading...</div>"); 
				$("#test_trends").html("<div>Loading...</div>");
				$("#samples").html("<div>Loading...</div>");
				$("#lab_gender").html("<div>Loading...</div>");
				$("#lab_age").html("<div>Loading...</div>");
				$("#ttime").html("<div>Loading...</div>");
				$("#results").html("<div>Loading...</div>");
				$("#lab_facility_rejections").html("<div>Loading...</div>");
				$("#poc").html("<div>Loading...</div>");
				$("#poc_outcomes").html("<div>Loading...</div>");

				$("#rejected").load("<?php echo base_url();?>charts/labs/rejection_trends/"+from[1]);
				$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>/"+from[1]);
				$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#lab_perfomance_stats").load("<?php echo base_url();?>charts/labs/lab_performance_stats/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#samples").load("<?php echo base_url();?>charts/labs/sample_types/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#lab_gender").load("<?php echo base_url();?>charts/labs/gender/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#lab_age").load("<?php echo base_url();?>charts/labs/ages/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#results").load("<?php echo base_url();?>charts/labs/results_outcome/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#poc").load("<?php echo base_url();?>charts/labs/poc_performance_stats/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#poc_outcomes").load("<?php echo base_url();?>charts/labs/poc_outcomes/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);

				var em = localStorage.getItem("my_lab");

				$("#lab_rejections").load("<?php echo base_url();?>charts/labs/rejections/"+em+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);
				$("#lab_facility_rejections").load("<?php echo base_url();?>charts/labs/site_rejections/"+em+"/"+from[1]+"/"+from[0]+"/"+to[1]+"/"+to[0]);

			}
		    
		});

		$("select").change(function(){
			em = $(this).val();
			em = parseInt(em);
			localStorage.setItem("my_lab", em);
			$("#fifth").hide();
			
			if(em == 0){

			
				$("#first").show();
	        	$("#second").hide();
	        	$("#fourth").hide();
	        	$("#breadcrum").hide();

	        	$("#lab_perfomance_stats").load("<?php echo base_url();?>charts/labs/lab_performance_stats");
				$("#rejected").load("<?php echo base_url();?>charts/labs/rejection_trends");
				$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>");
				$("#samples").load("<?php echo base_url();?>charts/labs/sample_types");
				$("#lab_gender").load("<?php echo base_url();?>charts/labs/gender");
				$("#lab_age").load("<?php echo base_url();?>charts/labs/ages");
				$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time");
				$("#results").load("<?php echo base_url();?>charts/labs/results_outcome");

				$(".display_date").load("<?php echo base_url('charts/labs/display_date'); ?>");

			}
			else{
				
				$("#first").hide();
	        	$("#second").show();
	        	// $("#fourth").show();

	        	if(em == 11 || em == '11'){
	        		$("#fifth").show();
	        	}

	        	$("#breadcrum").show();
	        	var t = $("#my_list option:selected").text();
	        	$("#breadcrum").html(t);
	        	$("#lab_summary").load("<?php echo base_url();?>charts/labs/summary/"+em);
	        	$("#graphs").load("<?php echo base_url();?>charts/labs/lab_trends/"+em);
	        	// $("#lab_facility_rejections").load("<?php // echo base_url();?>charts/labs/site_rejections/"+em);
	        	$("#poc").load("<?php echo base_url();?>charts/labs/poc_performance_stats");
	        	$("#poc_outcomes").load("<?php echo base_url();?>charts/labs/poc_outcomes");
				
			}
			$("#lab_rejections").html("<div>Loading...</div>");
			$("#lab_rejections").load("<?php echo base_url();?>charts/labs/rejections/"+em);
			
	    });

	});

	function date_filter(criteria, id)
 	{
		localStorage.setItem("to_year", 'null');
		localStorage.setItem("to_month", 'null');

 		if (criteria === "monthly") {
 			localStorage.setItem("from_year", 'null');
 			localStorage.setItem("from_month", id);
 			year = null;
 			month = id;
 		}else {
 			localStorage.setItem("from_year", id);
 			localStorage.setItem("from_month", 'null');
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
			
			$("#lab_rejections").html("<div>Loading...</div>");
			$("#lab_summary").html("<div>Loading...</div>");
	 		
	 		
	 		$("#lab_perfomance_stats").html("<div>Loading...</div>"); 
	 		$("#rejected").html("<div>Loading...</div>"); 
			$("#test_trends").html("<div>Loading...</div>");
			$("#samples").html("<div>Loading...</div>");
			$("#lab_gender").html("<div>Loading...</div>");
			$("#lab_age").html("<div>Loading...</div>");
			$("#ttime").html("<div>Loading...</div>");
			$("#results").html("<div>Loading...</div>");
			$("#lab_facility_rejections").html("<div>Loading...</div>");
			$("#poc").html("<div>Loading...</div>");
			$("#poc_outcomes").html("<div>Loading...</div>");

			var em = localStorage.getItem("my_lab");

			$("#lab_rejections").load("<?php echo base_url();?>charts/labs/rejections/"+em+"/"+year+"/"+month);
			$("#lab_facility_rejections").load("<?php echo base_url();?>charts/labs/site_rejections/"+em+"/"+year+"/"+month);
			$("#lab_summary").load("<?php echo base_url();?>charts/labs/summary/"+em+"/"+year);

			$("#rejected").load("<?php echo base_url();?>charts/labs/rejection_trends/"+year);
			$("#test_trends").load("<?php echo base_url('charts/labs/testing_trends');?>/"+year);
			$("#ttime").load("<?php echo base_url();?>charts/labs/turn_around_time/"+year+"/"+month);
			$("#lab_perfomance_stats").load("<?php echo base_url();?>charts/labs/lab_performance_stats/"+year+"/"+month);
			$("#poc").load("<?php echo base_url();?>charts/labs/poc_performance_stats/"+year+"/"+month);
			$("#poc_outcomes").load("<?php echo base_url();?>charts/labs/poc_outcomes/"+year+"/"+month);
			$("#samples").load("<?php echo base_url();?>charts/labs/sample_types/"+year+"/"+month);
			$("#lab_gender").load("<?php echo base_url();?>charts/labs/gender/"+year+"/"+month);
			$("#lab_age").load("<?php echo base_url();?>charts/labs/ages/"+year+"/"+month);
			$("#results").load("<?php echo base_url();?>charts/labs/results_outcome/"+year+"/"+month);
		});		
	}

	function expand_modal(div_name){
		$(div_name).modal('show');
	}
	
</script>