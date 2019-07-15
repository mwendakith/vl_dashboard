<script type="text/javascript">
	$().ready(function(){
		localStorage.setItem("subcounty_pmtct", 0);
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
    	
		$("#second").hide();
		$("#third").hide();
		$("#fourth").hide();
	});
</script>