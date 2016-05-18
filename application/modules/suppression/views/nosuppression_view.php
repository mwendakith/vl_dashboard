<?php?>
<style type="text/css">
	.navbar-inverse {
		border-radius: 0px;
	}
	.navbar .container-fluid .navbar-header .navbar-collapse .collapse .navbar-responsive-collapse .nav .navbar-nav {
		border-radius: 0px;
	}
	.panel {
		border-radius: 0px;
	}
	.panel-primary {
		border-radius: 0px;
	}
	.panel-heading {
		border-radius: 0px;
	}
	.list-group-item{
		margin-bottom: 0.5em;
	}
	.btn {
		margin: 0px;
	}
	.alert {
		margin-bottom: 0px;
		padding: 8px;
	}
	.filter {
		margin: 2px 20px;
	}
	.display_date {
		width: 130px;
		display: inline;
	}
	#filter {
		background-color: white;
		margin-bottom: 1.2em;
		margin-right: 0.1em;
		margin-left: 0.1em;
		padding-top: 0.5em;
		padding-bottom: 0.5em;
	}
	#year-month-filter {
		font-size: 12px;
	}

</style>
<div class="alert" style="margin-bottom: 1em;background-color: #CF000F;">
  	National Non-suppression rate: <strong>80%</strong>
</div>
<div class="row">
	<div class="col-md-6">
		<!-- Begining of the age gender suppresion failures -->
		<div class="panel panel-primary">
			<div class="panel-heading">
			  By Age & Gender <div class="display_date"></div>
			</div>
		  	<div class="panel-body">
		  	<div class="row">
		  		<div class="col-md-6">
		  			<div class="list-group">
		  				<a href="#" class="list-group-item active">
							    Gender
						</a>
		  				<a href="#" class="list-group-item">Male:300</a>
						<a href="#" class="list-group-item">Female: 400</a>
			  		</div>
		  		</div>
		  		<div class="col-md-6">
		  			<div class="list-group">
						<a href="#" class="list-group-item active">
						    Age Groups
						</a>
						<a href="#" class="list-group-item">0-4.9:</a>
						<a href="#" class="list-group-item">5-9.9</a>
						<a href="#" class="list-group-item">10-14.9:</a>
						<a href="#" class="list-group-item">15-17.8</a>
						<a href="#" class="list-group-item">18+</a>
		  			</div>
		  		</div>
		  		<div class="col-md-12">
		  			<div class="panel panel-primary">
		  				<div class="panel-body" id="genderAgeGrp">
		  					<div>Loading...</div>
		  				</div>
		  			</div>
		  		</div>
		  		
		  	</div>
		  	<!-- -->
		  </div>
		</div>
		<!-- End of the age gender suppresion failures -->
		<!-- Begining of Justification -->
		<div class="panel panel-primary">
				<div class="panel-heading">
					By Justification <div class="display_date"></div>
				</div>
			  <div class="panel-body">
			  	<div class="row">
			  		<div class="col-md-6">
			  			<div class="list-group">
			  				<a href="#" class="list-group-item active">
								    Reasons for Justification
							</a>
			  				<a href="#" class="list-group-item">Routine VL: 300</a>
							<a href="#" class="list-group-item">Confirmation of treatment Failure: 300</a>
							<a href="#" class="list-group-item">Clinical Failure: 300</a>
							<a href="#" class="list-group-item">Immunological Failure: 300</a>
							<a href="#" class="list-group-item">Single Drug Substitution: 300</a>
							<a href="#" class="list-group-item">Pregnant Mother: 300</a>
							<a href="#" class="list-group-item">Other: 300</a>
							<a href="#" class="list-group-item">No Data: 300</a>
							<a href="#" class="list-group-item">Lactating Mothers: 300</a>
							<a href="#" class="list-group-item">Baseline: 300</a>
			  			</div>
			  		</div>
			  		<div class="col-md-6">
			  			<div class="panel panel-primary">
			  				<div class="panel-body" id="justification">
			  					<div>Loading...</div>
			  				</div>
				  		</div>
				  	</div>
			  	</div>
			 </div>
		</div>
		<!-- End of Justification -->
		<!-- Begining of Regimen -->
		<div class="panel panel-primary">
				<div class="panel-heading">
					By Regimen <div class="display_date"></div>
				</div>
			  <div class="panel-body">
			  	<div class="row">
			  		<div class="col-md-6">
			  			<div class="list-group">
			  				<a href="#" class="list-group-item active">
								    Categorized by Regimen
							</a>
			  				<a href="#" class="list-group-item">Routine VL: 300</a>
							<a href="#" class="list-group-item">Confirmation of treatment Failure: 300</a>
							<a href="#" class="list-group-item">Clinical Failure: 300</a>
							<a href="#" class="list-group-item">Immunological Failure: 300</a>
							<a href="#" class="list-group-item">Single Drug Substitution: 300</a>
							<a href="#" class="list-group-item">Pregnant Mother: 300</a>
							<a href="#" class="list-group-item">Other: 300</a>
							<a href="#" class="list-group-item">No Data: 300</a>
							<a href="#" class="list-group-item">Lactating Mothers: 300</a>
							<a href="#" class="list-group-item">Baseline: 300</a>
			  			</div>
			  		</div>
			  		<div class="col-md-6">
			  			<div class="panel panel-primary">
			  				<div class="panel-body" id="regimen">
			  					<div>Loading...</div>
			  				</div>
				  		</div>
				  	</div>
			  	</div>
			 </div>
		</div>
		<!-- End of Regimen -->
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				  	Counties <div class="display_date"></div>
				  </div>
				  <div class="panel-body">
				    <div class="list-group">
		  				<a href="#" class="list-group-item">Nairobi</a>
						<a href="#" class="list-group-item">Nakuru</a>
						<a href="#" class="list-group-item">Trans Nzoia</a>
						<a href="#" class="list-group-item">Bungoma</a>
						<a href="#" class="list-group-item">Kisumu</a>
						<a href="#" class="list-group-item">Nairobi</a>
						<a href="#" class="list-group-item">Nakuru</a>
						<a href="#" class="list-group-item">Trans Nzoia</a>
						<a href="#" class="list-group-item">Bungoma</a>
						<a href="#" class="list-group-item">Kisumu</a>
		  			</div>
				  </div>
				</div>
				<div class="panel panel-primary">
				  <div class="panel-heading">
				  	Patners <div class="display_date"></div>
				  </div>
				  <div class="panel-body" id="county_summary">
				    <div class="list-group">
		  				<a href="#" class="list-group-item">EGPAF Kenya</a>
						<a href="#" class="list-group-item">Kenya AIDS Response Program (KARP)</a>
						<a href="#" class="list-group-item">African Medical And Research Foundation</a>
						<a href="#" class="list-group-item">AMPATH Plus</a>
						<a href="#" class="list-group-item">APHIAplus  Nyanza Western</a>
						<a href="#" class="list-group-item">EGPAF Kenya</a>
						<a href="#" class="list-group-item">Kenya AIDS Response Program (KARP)</a>
						<a href="#" class="list-group-item">African Medical And Research Foundation</a>
						<a href="#" class="list-group-item">AMPATH Plus</a>
						<a href="#" class="list-group-item">APHIAplus  Nyanza Western</a>
		  			</div>
				  </div>
				</div>
				<div class="panel panel-primary">
				  <div class="panel-heading">
				  	Regimens <div class="display_date"></div>
				  </div>
				  <div class="panel-body">
				    <div class="list-group">
		  				<a href="#" class="list-group-item">Plasma: 300</a>
						<a href="#" class="list-group-item">EDTA: 300</a>
						<a href="#" class="list-group-item">Plasma: 300</a>
						<a href="#" class="list-group-item">EDTA: 300</a>
						<a href="#" class="list-group-item">DBS: 300</a>
		  			</div>
				  </div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-primary">
				  <div class="panel-heading">
				  	Facility <div class="display_date"></div>
				  </div>
				  <div class="panel-body">
				    <div class="list-group">
		  				<a href="#" class="list-group-item">Mbale Health Centre (Taita Taveta)</a>
						<a href="#" class="list-group-item">10 Engineer VCT</a>
						<a href="#" class="list-group-item">3KR Health Centre</a>
						<a href="#" class="list-group-item">78 Tank Dispensary</a>
						<a href="#" class="list-group-item">8th Street Clinic</a>
						<a href="#" class="list-group-item">AAR City Centre Clinic</a>
						<a href="#" class="list-group-item">AAR Clinic Sarit Centre</a>
						<a href="#" class="list-group-item">AAR Kariobangi Clinic</a>
						<a href="#" class="list-group-item">AAR MEDICAL CLINIC KISUMU </a>
						<a href="#" class="list-group-item">AAR Medical Services (Kilindini)</a>
						<a href="#" class="list-group-item">AAR Nakuru Clinic </a>
						<a href="#" class="list-group-item">AAR Nyali Health Care</a>
						<a href="#" class="list-group-item">AAR Thika Road Clinic</a>
						<a href="#" class="list-group-item">Abakore Dispensary</a>
						<a href="#" class="list-group-item">Abandoned Child Care </a>
						<a href="#" class="list-group-item">Abel Migwi Johana Laboratory</a>
						<a href="#" class="list-group-item">Aberdare  Medical & Surgical Clinic</a>
						<a href="#" class="list-group-item">Aberdare Health Services</a>
						<a href="#" class="list-group-item">Abidha Health Centre</a>
						<a href="#" class="list-group-item">Able Medical Clinic</a>
						<a href="#" class="list-group-item">Abandoned Child Care </a>
						<a href="#" class="list-group-item">Abel Migwi Johana Laboratory</a>
						<a href="#" class="list-group-item">Aberdare  Medical & Surgical Clinic</a>
						<a href="#" class="list-group-item">Aberdare Health Services</a>
						<a href="#" class="list-group-item">Abidha Health Centre</a>
						<a href="#" class="list-group-item">Able Medical Clinic</a>
						<a href="#" class="list-group-item">Aberdare  Medical & Surgical Clinic</a>
						<a href="#" class="list-group-item">Aberdare Health Services</a>
						<a href="#" class="list-group-item">Abidha Health Centre</a>
						<a href="#" class="list-group-item">Able Medical Clinic</a>
		  			</div>
				  </div>
				</div>
			</div>
		</div>
		<!-- Begining of Sample Types -->
		<div class="panel panel-primary">
				<div class="panel-heading">
					Sample Types <div class="display_date"></div>
				</div>
			  <div class="panel-body">
			  	<div class="row">
			  		<div class="col-md-12">
			  			<div class="list-group">
			  				<a href="#" class="list-group-item active">
								    By Sample types
							</a>
			  				<a href="#" class="list-group-item">Plasma: 300</a>
							<a href="#" class="list-group-item">EDTA: 300</a>
							<a href="#" class="list-group-item">DBS: 300</a>
			  			</div>
			  		</div>
			  		<div class="col-md-12">
			  			<div class="panel panel-primary">
			  				<div class="panel-body" id="sampleType">
			  					<div>Loading...</div>
			  				</div>
				  		</div>
				  	</div>
			  	</div>
			 </div>
		</div>
		<!-- End of Sample Types -->

	</div>
</div>
<?php $this->load->view('nosuppression_view_footer')?>