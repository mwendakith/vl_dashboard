<div id="first">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Sample Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="regimen_outcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
</div>
<div id="second">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Suppression <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="samples">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-6 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	VL Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="vlOutcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Gender <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="gender">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Age <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="age">
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

</div>

<?php $this->load->view('sample_view_footer');?>