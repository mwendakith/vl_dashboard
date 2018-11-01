<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}
</style>

<div class="row" id="first">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Agencies Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="agency_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<div class="row" id="second">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" style="min-height: 4em;">
		  	<div class="col-sm-3">
		  		<div id="samples_heading">Testing Trends for Routine VL</div> <div class="display_range"></div>
		  	</div>
		    <div class="col-sm-3">
		    	<input type="submit" class="btn btn-primary" id="switchButton" onclick="switch_source()" value="Click to Switch to All Tests">
		    </div>
		  </div>
		  <div class="panel-body" id="samples">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-7 col-sm-3 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	VL Outcomes <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="vlOutcomes">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Routine VLs Outcomes by Gender <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="gender" style="height:650px;padding-bottom:0px;">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	Routine VLs Outcomes by Age <div class="display_date"></div>
		  	</div>
		  	<div class="panel-body" id="ageGroups">
		    	<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>
	<!-- Map of the country -->
	<div class="col-md-6 col-sm-4 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  	Justification for tests <div class="display_date"></div>
			</div>
			<div class="panel-body" id="justification" style="height:500px;">
				<center><div class="loader"></div></center>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  	<div class="panel-heading" style="min-height: 4em;">
		  		<div>Partner Suppression for Routine VL</div> <div class="display_date"></div>
		  	</div>
		  	<div class="panel-body" id="partners">
		    	<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  	<div class="panel-heading" style="min-height: 4em;">
		  		<div>Partner Current Suppression</div> <!-- <div class="display_date"></div> -->
		  	</div>
		  	<div class="panel-body" id="partners_current_suppression">
		    	<center><div class="loader"></div></center>
		  	</div>
		</div>
	</div>
</div>
		
<?php $this->load->view('partner_agencies_view_footer'); ?>