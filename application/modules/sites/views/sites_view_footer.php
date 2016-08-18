<?php
// public $county;
// if ($this->session->userdata('county_filter')) {
// 	$county = $this->session->userdata('county_filter');
// } else {
// 	$county = null;
// }

?>
<script type="text/javascript">
	$().ready(function(){
		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
		$("#first").show();
		$("#second").hide();

		$("select").change(function() {
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_site_data", { site: em } );

	        // Put the results in a div
	        posting.done(function( data ) {
	        	$.get("<?php echo base_url();?>template/dates", function(data){
	        		obj = $.parseJSON(data);
			
					if(obj['month'] == "null" || obj['month'] == null){
						obj['month'] = "";
					}
					$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
					$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	        	});

	        	$.get("<?php echo base_url();?>template/breadcrum", function(data){
	        		$("#breadcrum").html(data);
	        	});

	        	if (em=="NA") {
	        		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
					$("#first").show();
					$("#second").hide();
				} else {
					$("#first").hide();
					$("#second").show();

					$("#tsttrends").html("<center><div class='loader'></div></center>");
					$("#stoutcomes").html("<center><div class='loader'></div></center>");
					$("#vlOutcomes").html("<center><div class='loader'></div></center>");
					$("#ageGroups").html("<center><div class='loader'></div></center>");
					$("#gender").html("<center><div class='loader'></div></center>");
					$("#justification").html("<center><div class='loader'></div></center>");

					$("#tsttrends").load("<?php echo base_url('charts/sites/site_trends');?>/"+null+"/"+null+"/"+data);
					$("#stoutcomes").load("<?php echo base_url('charts/sites/site_outcomes_chart');?>/"+null+"/"+null+"/"+data);
					$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_Vlotcomes');?>/"+null+"/"+null+"/"+data);
					$("#ageGroups").load("<?php echo base_url('charts/sites/site_agegroups');?>/"+null+"/"+null+"/"+data);
					$("#gender").load("<?php echo base_url('charts/sites/site_gender');?>/"+null+"/"+null+"/"+data);
					$("#justification").load("<?php echo base_url('charts/sites/site_justification');?>/"+null+"/"+null+"/"+data);
				}
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
		var county = <?php echo json_encode($this->session->userdata('county_filter')); ?>;
		console.log(county);
		if (county) {
			console.log('Something to show you today');
		} else {
			console.log('Nothing to show you today');
			// $("#siteOutcomes").load("<?php //echo base_url('charts/sites/site_outcomes');?>");
		}
		///console.log(county);

	 	$("#tsttrends").html("<center><div class='loader'></div></center>");
		$("#stoutcomes").html("<center><div class='loader'></div></center>");
		$("#vlOutcomes").html("<center><div class='loader'></div></center>");
		$("#ageGroups").html("<center><div class='loader'></div></center>");
		$("#gender").html("<center><div class='loader'></div></center>");

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