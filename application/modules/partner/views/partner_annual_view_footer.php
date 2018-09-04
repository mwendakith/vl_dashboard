<script type="text/javascript">
	$().ready(function(){

		$(".display_current_range").html("Oct, 2016 - Sep, 2017");

		$("#countys").html("<div>Loading...</div>");
		$("#partners").html("<div>Loading...</div>");
		$("#subcounty").html("<div>Loading...</div>");
		$("#facilities").html("<div>Loading...</div>");

		$("#countys_g").html("<div>Loading...</div>");
		$("#partners_g").html("<div>Loading...</div>");
		$("#subcounty_g").html("<div>Loading...</div>");
		$("#facilities_g").html("<div>Loading...</div>");

		$("#countys_a").html("<div>Loading...</div>");
		$("#partners_a").html("<div>Loading...</div>");
		$("#subcounty_a").html("<div>Loading...</div>");
		$("#facilities_a").html("<div>Loading...</div>");

		$("#countys_na").html("<div>Loading...</div>");
		$("#partners_na").html("<div>Loading...</div>");
		$("#subcounty_na").html("<div>Loading...</div>");
		$("#facilities_na").html("<div>Loading...</div>");

		$("#current_sup").load("<?php echo base_url('charts/summaries/current_suppression/null/null/1'); ?>");
		$("#current_sup_gender").load("<?php echo base_url('charts/summaries/current_gender/0/3/1000/1'); ?>");
		$("#current_sup_age").load("<?php echo base_url('charts/summaries/current_age/0/3/1000/1'); ?>");


		$("#countys").load("<?php echo base_url('charts/summaries/county_listing/1/3/null/1');?>");
		$("#subcounty").load("<?php echo base_url('charts/summaries/subcounty_listing/2/3/null/1');?>");
		$("#partners").load("<?php echo base_url('charts/summaries/partner_listing/3/3/1000/1');?>");
		$("#facilities").load("<?php echo base_url('charts/summaries/site_listing/4/3/null/1');?>");

		$("#countys_g").load("<?php echo base_url('charts/summaries/county_listing_gender/1/3/null/1');?>");
		$("#partners_g").load("<?php echo base_url('charts/summaries/partner_listing_gender/3/3/1000/1');?>");
		$("#subcounty_g").load("<?php echo base_url('charts/summaries/subcounty_listing_gender/2/3/null/1');?>");
		$("#facilities_g").load("<?php echo base_url('charts/summaries/site_listing_gender/4/3/null/1');?>");

		$("#countys_a").load("<?php echo base_url('charts/summaries/county_listing_age/1/3/null/1');?>");
		$("#partners_a").load("<?php echo base_url('charts/summaries/partner_listing_age/3/3/1000/1');?>");
		$("#subcounty_a").load("<?php echo base_url('charts/summaries/subcounty_listing_age/2/3/null/1');?>");
		$("#facilities_a").load("<?php echo base_url('charts/summaries/site_listing_age/4/3/null/1');?>");

		$("#countys_na").load("<?php echo base_url('charts/summaries/county_listing_age_n/1/3/null/1');?>");
		$("#partners_na").load("<?php echo base_url('charts/summaries/partner_listing_age_n/3/3/1000/1');?>");
		$("#subcounty_na").load("<?php echo base_url('charts/summaries/subcounty_listing_age_n/2/3/null/1');?>");
		$("#facilities_na").load("<?php echo base_url('charts/summaries/site_listing_age_n/4/3/null/1');?>");

		$("select").change(function(){
			em = $(this).val();

			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	     
	        // Put the results in a div
	        posting.done(function( data ) {

	        	data = JSON.parse(data);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
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


	        	// alert(data);
	        	$("#current_sup").html("<center><div class='loader'></div></center>");
	        	$("#current_sup_gender").html("<center><div class='loader'></div></center>");
	        	$("#current_sup_age").html("<center><div class='loader'></div></center>");

				$("#countys").html("<div>Loading...</div>");
				$("#subcounty").html("<div>Loading...</div>");
				$("#facilities").html("<div>Loading...</div>");	

				$("#countys_g").html("<div>Loading...</div>");
				$("#subcounty_g").html("<div>Loading...</div>");
				$("#facilities_g").html("<div>Loading...</div>");

				$("#countys_a").html("<div>Loading...</div>");
				$("#subcounty_a").html("<div>Loading...</div>");
				$("#facilities_a").html("<div>Loading...</div>");

				$("#countys_na").html("<div>Loading...</div>");
				$("#subcounty_na").html("<div>Loading...</div>");
				$("#facilities_na").html("<div>Loading...</div>");	

				$("#countys").load("<?php echo base_url('charts/summaries/county_listing/1/3');?>/"+data+"/1");
				$("#subcounty").load("<?php echo base_url('charts/summaries/subcounty_listing/2/3');?>/"+data+"/1");
				$("#facilities").load("<?php echo base_url('charts/summaries/site_listing/4/3');?>/"+data+"/1");

				$("#countys_g").load("<?php echo base_url('charts/summaries/county_listing_gender/1/3');?>/"+data+"/1");
				$("#subcounty_g").load("<?php echo base_url('charts/summaries/subcounty_listing_gender/2/3');?>/"+data+"/1");
				$("#facilities_g").load("<?php echo base_url('charts/summaries/site_listing_gender/4/3');?>/"+data+"/1");

				$("#countys_a").load("<?php echo base_url('charts/summaries/county_listing_age/1/3');?>/"+data+"/1");
				$("#subcounty_a").load("<?php echo base_url('charts/summaries/subcounty_listing_age/2/3');?>/"+data+"/1");
				$("#facilities_a").load("<?php echo base_url('charts/summaries/site_listing_age/4/3');?>/"+data+"/1");

				$("#countys_na").load("<?php echo base_url('charts/summaries/county_listing_age_n/1/3');?>/"+data+"/1");
				$("#subcounty_na").load("<?php echo base_url('charts/summaries/subcounty_listing_age_n/2/3');?>/"+data+"/1");
				$("#facilities_na").load("<?php echo base_url('charts/summaries/site_listing_age_n/4/3');?>/"+data+"/1");


			
				$("#current_sup").load("<?php echo base_url('charts/summaries/current_suppression/null'); ?>/"+data+"/1");
				$("#current_sup_gender").load("<?php echo base_url('charts/summaries/current_gender/0/3'); ?>/"+data+"/1");
				$("#current_sup_age").load("<?php echo base_url('charts/summaries/current_age/0/3'); ?>/"+data+"/1");
	        });
		});
	});

	

	function expand_modal(div_name){
		$(div_name).modal('show');
	}
	
</script>