<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- about this site -->
		<meta name="description" content="A web platform that for Viral Load" />
		<meta name="keywords" content="EID, VL, Early infant diagnosis, Viral Load, HIV, AIDS, HIV/AIDS, adults, pedeatrics, infants, VL Dashboard" />
		<meta name="author" content="Viralload">
		<meta name="Resource-type" content="Document">
		<?php      	
			$this->load->view('utils/dynamicLoads');
		?>
		<link rel=icon href="<?php echo base_url('assets/img/kenya-coat-of-arms.png');?>" type="image/png" />
		<title>
			Dashboard
		</title>
		<style type="text/css">
			@import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700");
			@import url("https://fonts.googleapis.com/css?family=Roboto:400,300,500,700");
			/*
			 *
			 *   INSPINIA - Responsive Admin Theme
			 *   version 2.6.2
			 *
			*/
			h1,
			h2,
			h3,
			h4,
			h5,
			h6 {
			  font-weight: 100;
			}
			h1 {
			  font-size: 30px;
			}
			h2 {
			  font-size: 24px;
			}
			h3 {
			  font-size: 16px;
			}
			h4 {
			  font-size: 14px;
			}
			h5 {
			  font-size: 12px;
			}
			h6 {
			  font-size: 10px;
			}
			h3,
			h4,
			h5 {
			  margin-top: 5px;
			  font-weight: 600;
			}
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
			.filter-div {
				background-color: white;
				margin-bottom: 1.2em;
				margin-right: 0.1em;
				margin-left: 0.1em;
				padding-top: 0.5em;
				padding-bottom: 0.5em;
			}
			.div-spacing {
				margin-bottom: 1.2em;
				margin-right: 0.1em;
				margin-left: 0.1em;
				padding-top: 0.5em;
				padding-bottom: 0.5em;
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
			.nav {
				color: black;
			}
		</style>
	</head>
	<body>
	<?php //echo "<pre>";print_r($_SERVER['REQUEST_URI']);die();?>
		<!-- Begining of Navigation Bar -->
		<div class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="javascript:void(0)" style="padding:0px;padding-top:4px;padding-left:4px;"><img src="<?php echo base_url();?>assets/img/nascop_pepfar_logo.jpg" style="width:250px;height:50px;"/></a>
				</div>
				<div class="navbar-collapse collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						
					</ul>
					<!-- <form class="navbar-form navbar-left" id="1267192336">
						<div class="form-group">
							<input type="text" class="form-control col-md-8" placeholder="Search">
						</div>
					</form> -->
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo base_url();?>">Summary</a></li>
						<li class="dropdown">
							<a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">County/Sub-County
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url();?>county">County</a></li>
								<li><a href="<?php echo base_url();?>county/pmtct">County PMTCT</a></li>
								<li><a href="<?php echo base_url();?>county/tat">County TAT</a></li>
								<li><a href="<?php echo base_url();?>county/partner">County Partner</a></li>
								<li><a href="<?php echo base_url();?>county/subCounty">Sub-County</a></li>
								<li><a href="<?php echo base_url();?>county/subcountypmtct">Sub-County PMTCT</a></li>
								<li><a href="<?php echo base_url();?>county/subCountytat">Sub-County TAT</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Facilities
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url();?>sites">Facilities</a></li>
								<li><a href="<?php echo base_url();?>sites/pmtct">Facilities PMTCT</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Labs
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url();?>labs">Lab Performance</a></li>
								<li><a href="<?php echo base_url();?>labs/poc">POC</a></li>
								<li><a href="<?php echo base_url();?>live">Lab Live</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Partners
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url();?>partner">Summary</a></li>
								<li><a href="<?php echo base_url();?>partner/trends">Trends</a></li>
								<li><a href="<?php echo base_url();?>partner/sites">Partner Facilities</a></li>
								<li><a href="<?php echo base_url();?>partner/age">Partner Age</a></li>
								<li><a href="<?php echo base_url();?>partner/regimen">Partner Regimen</a></li>
								<li><a href="<?php echo base_url();?>partner/counties">Partner Counties</a></li>
								<li><a href="<?php echo base_url();?>partner/pmtct">Partner PMTCT</a></li>
								<li><a href="<?php echo base_url();?>partner/current">Partner Current Suppression</a></li>
								<li><a href="<?php echo base_url();?>partner/tat">Partner TAT</a></li>
								<li><a href="<?php echo base_url();?>partner/agencies">Funding Agencies</a></li>
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Current Suppression
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo base_url();?>current">Current Suppression</a></li>
								<li><a href="<?php echo base_url();?>suppression/nosuppression">Non-suppression</a></li>
								<li><a href="<?php echo base_url();?>regimen">Regimen Analysis</a></li>
								<li><a href="<?php echo base_url();?>age">Age Analysis</a></li>
								<li><a href="<?php echo base_url();?>sample">Sample Analysis</a></li>
								<li><a href="<?php echo base_url();?>pmtct">PMTCT Analysis</a></li>
								<!-- <li><a href="<?php //echo base_url();?>summary/current">Summary Page</a></li> -->
							</ul>
						</li>
						<li><a href="<?php echo base_url();?>trends">Trends</a></li>
						<li><a href="https://nascop.org">Resources</a></li>
						<li><a href="https://eid.nascop.org">EID View</a></li>
						<!-- <li><a href="<?php echo base_url();?>live">Live Data</a></li> -->
						<!-- <li><a href="https://api.nascop.org/">API Documentation</a></li> -->
						<li><a href="<?php echo base_url();?>contacts">Contact Us</a></li>
						<!-- <li><a href="<?php echo base_url();?>county">County View</a></li> -->
						<li><a href="https://eiddash.nascop.org/">Login</a></li>
						<!-- <li><a href="javascript:void(0)">Link</a></li> -->
						<!-- <li class="dropdown"> -->
							<!-- <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown
							<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:void(0)">Action</a></li>
								<li><a href="javascript:void(0)">Another action</a></li>
								<li><a href="javascript:void(0)">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="javascript:void(0)">Separated link</a></li>
							</ul> -->
						<!-- </li> -->
					</ul>
				</div>
			</div>
		</div>
		<!-- End of Navigation Bar -->
		<!-- Begining of Dashboard area -->
		<div class="container-fluid">