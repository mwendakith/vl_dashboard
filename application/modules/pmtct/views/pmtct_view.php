<div id="first">
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    PMTCT Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="pmtct_outcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    PMTCT Suppression Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="pmtct_sup_outcomes">
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
			    Testing Trends <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="pmtct_testing_trends">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	VL Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="pmtct_vlOutcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Counties <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="countiespmtct">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Partners <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="partnerspmtct">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Sub-counties <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="subcountiespmtct">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Facilities <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="Facilitiespmtct">
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
			  <div class="panel-body" id="countypmtct">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>

</div>

<?= @$this->load->view('pmtct_footer_view'); ?>