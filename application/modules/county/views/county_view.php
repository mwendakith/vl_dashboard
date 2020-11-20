<div class="row">
		<!-- Map of the country -->
	
</div>

<div id="first">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Counties Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				Counties <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="county_sites">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				Counties Outcome by Age and Gender <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="county_outcome_age_gender">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
	</div>
</div>

<div id="second">
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  Sub-Counties Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="subcounty">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  Sub-Counties Suppression <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="subcountypos">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>


		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Tests done by unique patients <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="long_tracking">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>

		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Current Suppression Rate <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="current_sup_dynamic">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>

		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Suppression Rate <div class="display_current_range"></div>
			  </div>
			  <div class="panel-body" id="current_sup">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  Sub-Counties <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="sub_counties">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  County Facilities <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="county_facilities">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
		<!-- <div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  Partners <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="partners">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div> -->
		<!-- <div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  Facilities PMTCT <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="facilities_pmtct">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div> -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	County TAT Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county_tat_outcomes">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	County TAT Details <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county_tat_details">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
			  County Partners Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county_partners">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
				  Partners <div class="display_date"></div>
				</div>
			  	<div class="panel-body" id="partners">
			  		<center><div class="loader"></div></center>
			  	</div>
			</div>
		</div>
	</div>
</div>




<?php $this->load->view('county_view_footer'); ?>