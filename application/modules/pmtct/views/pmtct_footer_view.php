<script type="text/javascript">
	$(document).ready(function(){
		$("#first").show();
		$("#second").hide();
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
    	$("#pmtct_outcomes").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+1+"/"+null+"/"+null+"/"+null+"/"+1);
		$("#pmtct_sup_outcomes").load("<?= @base_url('charts/pmtct/pmtct_outcomes'); ?>/"+null+"/"+null+"/"+2+"/"+null+"/"+null+"/"+null+"/"+1);
	});
</script>