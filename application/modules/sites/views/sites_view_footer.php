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

				$("#tsttrends").load("<?php echo base_url('charts/sites/site_outcomes_chart');?>/"+null+"/"+null+"/"+value);
				$("#stoutcomes").load("<?php echo base_url('charts/sites/site_trends');?>/"+null+"/"+null+"/"+value);
				$("#vlOutcomes").load("<?php echo base_url('charts/sites/site_Vlotcomes');?>/"+null+"/"+null+"/"+value);
				$("#ageGroups").load("<?php echo base_url('charts/sites/site_agegroups');?>/"+null+"/"+null+"/"+value);
				$("#gender").load("<?php echo base_url('charts/sites/site_gender');?>/"+null+"/"+null+"/"+value);
				$("#justification").load("<?php echo base_url('charts/sites/site_justification');?>/"+null+"/"+null+"/"+value);
			}
		});
	});
	function ageModal()
	{
		$('#agemodal').modal('show');
		// $('#CatAge').load('<?php echo base_url();?>charts/summaries/agebreakdown');
	}
</script>