<script type="text/javascript">
	$(document).ready(function(){
		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
		$("#partner_sites").hide();
		$("#sites_all").show();


		$("select").change(function(){
			$("#partnerSites").html("<center><div class='loader'></div></center>");
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	        
			posting.done(function( data ) {
	        	
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		
	        		$("#breadcrum").html(data);
	        	});
	        });
			if (em == "NA") {
				$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
				$("#partner_sites").hide();
				$("#sites_all").show();
			} else {
				$("#sites_all").hide();
				$("#partner_sites").show();
				$("#partnerSites").load("<?php echo base_url('charts/sites/partner_sites');?>/"+null+"/"+null+"/"+null+"/"+em);
			}
		});
	});
</script>