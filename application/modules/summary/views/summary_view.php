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
<div class="row">
	<!-- Map of the country -->
	<div class="col-md-3 col-sm-3 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		  	VL Outcomes <div class="display_date" ></div>
		  </div>
		  <div class="panel-body" id="vlOutcomes">
		    <div>Loading...</div>
		  </div>
		  <div>
		  	<ul>
		  		<li>Total Tests: 10000</li>
		  		<li>Suspected Failures: 1000</li>
		  		<li>Rejected: 1000</li>
		  		<li>Sites Sending: 400</li>
		  	</ul>
		  </div>
		</div>
	</div>
	<!-- Map of the country -->
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="row">
			<div class="panel panel-primary">
			  <div class="panel-heading">
				  Justification for tests <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="justification">
			    <div>Loading...</div>
			  </div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    Age <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="ageGroups">
				    <div>Loading...</div>
				  </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				    Gender <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="gender">
				    <div>Loading...</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    Sample Types <div class="display_range"></div>
		  </div>
		  <div class="panel-body" id="samples">
		    <div>Loading...</div>
		  </div>
		</div>
	</div>
</div>
<div class="row">
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		  	County Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="county">
		    <div>Loading...</div>
		  </div>
		</div>
	</div>
</div>
		
<?php $this->load->view('summary_view_footer'); ?>