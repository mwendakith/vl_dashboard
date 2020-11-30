<script type="text/javascript">
	$(document).ready(function(){
		$.get("<?php echo base_url();?>template/dates", function(data){
    		obj = $.parseJSON(data);
	
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
    	});
		
		$("#partner_sites").hide();
		$("#sites_all").show();
		$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
		
		$("select").change(function(){
			$("#partnerSites").html("<center><div class='loader'></div></center>");
			em = $(this).val();
			
			// Send the data using post
	        var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: em } );
	        $.get("<?php echo base_url();?>template/dates", function(data){
	    		obj = $.parseJSON(data);
		
				if(obj['month'] == "null" || obj['month'] == null){
					obj['month'] = "";
				}
				$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
				$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
	    	});
			posting.done(function( data ) {
	        	data = JSON.parse(data);
	        	$.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
	        		
	        		$("#breadcrum").html(data);
	        	});
	        	if (em == "NA") {
					$("#partner_sites").hide();
					$("#sites_all").show();
					$("#siteOutcomes").html("<center><div class='loader'></div></center>");
					$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
				} else {
					$("#sites_all").hide();
					$("#partner_sites").show();
					$("#partnerSites").html("<center><div class='loader'></div></center>");
					$("#partnerSites").load("<?php echo base_url('charts/sites/partner_sites');?>/"+null+"/"+null+"/"+em);
				}
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
			    $.get("<?php echo base_url();?>partner/check_partner_select", function (data) {
					var partner = data;
					partner = $.parseJSON(partner);
					
					if (partner==0) {
						$("#partner_sites").hide();
						$("#sites_all").show();
						$("#siteOutcomes").html("<center><div class='loader'></div></center>");
						$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
					} else {
						$("#sites_all").hide();
						$("#partner_sites").show();
						$("#partnerSites").html("<center><div class='loader'></div></center>");
						$("#partnerSites").load("<?php echo base_url('charts/sites/partner_sites');?>/"+from[1]+"/"+from[0]+"/"+partner+"/"+to[1]+"/"+to[0]);
					}
				});
			}
		    
		});
	});

	function date_filter(criteria, id)
	{
		// console.log(criteria+":"+id);
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
			
			if(obj['month'] == "null" || obj['month'] == null){
				obj['month'] = "";
			}
			$(".display_date").html("( "+obj['year']+" "+obj['month']+" )");
			$(".display_range").html("( "+obj['prev_year']+" - "+obj['year']+" )");
			
			$.get("<?php echo base_url();?>partner/check_partner_select", function (newdata) {
				var partner = newdata;
				console.log(partner);
				partner = $.parseJSON(partner);
				
				if (partner==0) {
					$("#partner_sites").hide();
					$("#sites_all").show();
					$("#siteOutcomes").html("<center><div class='loader'></div></center>");
					$("#siteOutcomes").load("<?php echo base_url('charts/sites/site_outcomes');?>");
				} else {
					$("#sites_all").hide();
					$("#partner_sites").show();
					$("#partnerSites").html("<center><div class='loader'></div></center>");
					$("#partnerSites").load("<?php echo base_url('charts/sites/partner_sites');?>/"+year+"/"+month+"/"+partner);
				}
			});
		});
	}
</script>