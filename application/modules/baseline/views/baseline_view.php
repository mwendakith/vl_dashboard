
<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Tests by Sample Type <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="samples">
		  	<center><div class="loader"></div></center>
		  </div>
		  
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Tests by Gender <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="gender" style="height:650px;padding-bottom:0px;">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Tests by Age <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="age">
		    <center><div class="loader"></div></center>
		  </div>
		  <div>
		  	<center><button class="btn btn-default" onclick="ageModal();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">Click here for breakdown</button></center>
		  </div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" id="heading">
		  	Partner Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" id="heading">
		  	County Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="county">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" id="heading">
		  	Subcounty Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="subcounty">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" id="heading">
		  	Facility Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="facility">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>


<?php $this->load->view('baseline_view_footer');?>