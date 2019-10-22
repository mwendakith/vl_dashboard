<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}
	#nattatdiv {
		background-color: white;
		margin-right: 1em;
		margin-left: 1em;
		margin-bottom: 1em;
	}
	.title-name {
		color: blue;
	}
	#title {
		padding-top: 1.5em;
	}
</style>
<div class="div-spacing">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<center><h4 style="color: ##f03434;">*All Stats based on Unique Patients` last VL result in the selected time period*</h4></center>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading" style="min-height: 4em;">
				  	Total on ART<div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="total-art">
			   	<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading" style="min-height: 4em;">
				  	Total VLs Done<div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="total-vl-done">
			   	<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading" style="min-height: 4em;">
				  	Current Suppression<div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="current-suppression">
			   	<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Age Cascade <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-4" id="age-pie">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-8" id="age-breakdown">
							<center><div class="loader"></div></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Current Suppression <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-less-25">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-over-25">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-chart">
							<center><div class="loader"></div></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Adolescents <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div class="row">
						<center>Loading...</center>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-less-25">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-over-25">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="current-age-pie-chart">
							<center><div class="loader"></div></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Current Suppression <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div id="current-suppression-adolescents">
						<center><div class="loader"></div></center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					PMTCT <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div id="pmtct">
						<center><div class="loader"></div></center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Linkage to Care & Treatment <div class="display_date" ></div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-4" id="linkage-breakdown">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="linkage-chart">
							<center><div class="loader"></div></center>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" id="linkage-pie">
							<center><div class="loader"></div></center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
<script type="text/javascript">
	var types = {county:1,subcounty:2,facility:3,partner:4};
	// Events listeners when the document is ready
	$().ready(function(){
		// Load the initail charts
		// loadCharts();

		$("select").change(function(){
			elementID = $(this).attr('id');
			elementValue = $(this).val();
			if (vd.getFilter(elementID) == null)
				vd.setFilter(elementID, elementValue);
			console.log(vd.getFilter(elementID));
		});
	});

	function loadCharts() {
		// Load from the procedures
		$("#total-vl-done").load("<?php echo base_url('charts/summaries/justification'); ?>");
		$("#age-pie").load("<?php echo base_url('charts/summaries/current_summary_age'); ?>");
		$("#age-breakdown").load("<?php echo base_url('charts/summaries/current_summary_age_breakdown'); ?>");
		$("#current-age-pie-less-25").load("<?php echo base_url('charts/summaries/current_summary_suppression_age'); ?>");
		$("#current-age-pie-over-25").load("<?php echo base_url('charts/summaries/current_summary_suppression_age/null/null/false'); ?>");

		// Load from the API takes longer to load
		$("#total-art").load("<?php echo base_url('charts/summaries/get_patients'); ?>");
		$("#current-suppression").load("<?php echo base_url('charts/summaries/get_current_suppresion'); ?>");
	}

	vd = {
	  	setFilter: function(filterItem, filterValue) {
	  		if (!(filterItem == null || filterItem == undefined))
	    		localStorage.setItem(filterItem, filterValue);
	  	},
	  	getFilter: function(filterItem) {
	  		return localStorage.getItem(filterItem);
	  	}
	}
</script>