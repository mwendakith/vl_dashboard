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

<div class="row" id="third">
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
</div>
<div class="row" id="second">
	<!-- Map of the country -->
	<div class="col-md-7 col-sm-7 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	VL Outcomes <div class="display_date" ></div>
		  </div>
		  <div id="vlOutcomes">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Routine VLs Outcomes by Gender <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="gender">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<!-- Map of the country -->
	<div class="col-md-6">
		<div class="panel panel-default">
				  <div class="panel-heading">
				    Routine VLs Outcomes by Age <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="ageGroups">
				    <center><div class="loader"></div></center>
				  </div>
				  <div>
				  	<center><button class="btn btn-default" onclick="ageModal();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">Click here for breakdown</button></center>
				  </div>
				</div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="panel panel-default">
		  	<div class="panel-heading">
			  	Justification for tests <div class="display_date"></div>
		  	</div>
			<div class="panel-body" id="justification">
			    <center><div class="loader"></div></center>
			</div>
		  	<div>
		  		<center><button class="btn btn-default" onclick="justificationModal();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">Click here for breakdown</button></center>
		  	</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Tests done by unique patients <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="long_tracking">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>

		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Suppression Rate (Last 12 months) 
			  </div>
			  <div class="panel-body" id="current_sup">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>


	
	
</div>

<div class="row" id="first">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partner Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="agemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Age Category Breakdown</h4>
      </div>
      <div class="modal-body" id="CatAge">
        <center><div class="loader"></div></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="justificationmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pregnant and Lactating Mothers</h4>
      </div>
      <div class="modal-body" id="CatJust">
        <center><div class="loader"></div></center>
      </div>
    </div>
  </div>
</div>
		
<?php $this->load->view('partner_summary_view_footer'); ?>