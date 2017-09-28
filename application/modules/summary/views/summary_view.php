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
	.key {
		font-size: 11px;
		margin-top: 0.5em;
	}
	.cr {
		background-color: rgba(255, 0, 0, 0.498039);
	}
	.rp {
		background-color: rgba(255, 255, 0, 0.498039);
	}
	.pd {
		background-color: rgba(0, 255, 0, 0.498039);
	}
	.cd {
		width: 0px;
		height: 0px;
		border-left: 8px solid transparent;
		border-right: 8px solid transparent;
		border-top: 8px solid black;
	}
</style>
<div class="row">
	<div class="col-md-12" id="nattatdiv">
		<div class="col-md-6 col-md-offset-3">
			<div class="col-md-4 title-name" id="title">
				<center>National TAT <l style="color:red;">(Days)</l></center>
			</div>
			<div class="col-md-8">
				<div id="nattat"></div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="title-name">Key</div>
			<div class="row">
				<div class="col-md-6">
					<div class="key cr"><center>Collection Receipt (C-R)</center></div>
					<div class="key rp"><center>Receipt to Processing (R-P)</center></div>
				</div>
				<div class="col-md-6">
					<div class="key pd"><center>Processing Dispatch (P-D)</center></div>
					<div class="key"><center><div class="cd"></div>Collection Dispatch (C-D)</center></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading" onclick="switch_source()">
		    <div id="samples_heading">Testing Trends for Routine VL</div> (Click to switch) <div class="display_range"></div>
		  </div>
		  <div class="panel-body" id="samples">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<div class="row">
	<!-- Map of the country -->
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
		    Gender <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="gender" style="height:650px;padding-bottom:0px;">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Age <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="ageGroups">
		    <center><div class="loader"></div></center>
		  </div>
		  <div>
		  	<center><button class="btn btn-default" onclick="ageModal();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">Click here for breakdown</button></center>
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
		  <div>
		  	<center><button class="btn btn-default" onclick="justificationModal();" style="background-color: #1BA39C;color: white;margin-bottom: 1em;">Click here for breakdown</button></center>
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

<?php $this->load->view('summary_view_footer'); ?>