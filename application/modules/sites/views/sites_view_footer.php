<script type="text/javascript">
	$().ready(function(){
		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
		$("#first").show();
		$("#second").hide();

		$("select").change(function() {
			value = $(this).val();

			if (value=="NA") {
				$("#first").show();
				$("#second").hide();
			} else {
				$("#first").hide();
				$("#second").show();

				$("#tsttrends").load("<center><div class='loader'></div></center>");
				$("#stoutcomes").load("<center><div class='loader'></div></center>");
				$("#vlOutcomes").load("<center><div class='loader'></div></center>");
				$("#ageGroups").load("<center><div class='loader'></div></center>");
				$("#gender").load("<center><div class='loader'></div></center>");
				$("#justification").load("<center><div class='loader'></div></center>");

				$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+null+"/"+null+"/"+value);
				$("#stoutcomes").load("<?php echo base_url('charts/sites/site_outcomes_chart');?>/"+null+"/"+null+"/"+value);
				$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_Vlotcomes');?>/"+null+"/"+null+"/"+value);
				$("#ageGroups").load("<?php echo base_url('charts/sites/site_agegroups');?>/"+null+"/"+null+"/"+value);
				$("#gender").load("<?php echo base_url('charts/sites/site_gender');?>/"+null+"/"+null+"/"+value);
				$("#justification").load("<?php echo base_url('charts/sites/site_justification');?>/"+null+"/"+null+"/"+value);
			}
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
	 	$("#tsttrends").load("<center><div class='loader'></div></center>");
		$("#stoutcomes").load("<center><div class='loader'></div></center>");
		$("#vlOutcomes").load("<center><div class='loader'></div></center>");
		$("#ageGroups").load("<center><div class='loader'></div></center>");
		$("#gender").load("<center><div class='loader'></div></center>");

		$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+year+"/"+month+"/"+null);
		$("#stoutcomes").load("<?php echo base_url('charts/sites/site_outcomes_chart');?>/"+year+"/"+month+"/"+null);
		$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_Vlotcomes');?>/"+year+"/"+month+"/"+null);
		$("#ageGroups").load("<?php echo base_url('charts/sites/site_agegroups');?>/"+year+"/"+month+"/"+null);
		$("#gender").load("<?php echo base_url('charts/sites/site_gender');?>/"+year+"/"+month+"/"+null);
		$("#justification").load("<?php echo base_url('charts/sites/site_justification');?>/"+year+"/"+month+"/"+null);
 	}

	function ageModal()
	{
		$('#agemodal').modal('show');
		// $('#CatAge').load('<?php echo base_url();?>charts/summaries/agebreakdown');
	}
</script>