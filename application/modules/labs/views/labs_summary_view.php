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
<div id="first">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        LAB PERFORMANCE STATS <div class="display_date"></div>
	      </div>
	      <div class="panel-body" id="lab_perfomance_stats">
	        <center><div class="loader"></div></center>
	      </div>
	    </div>
	  </div>
	</div>


	<div class="row">
		<!-- Map of the country -->
		<div style="color:red;"><center>Click on Lab(s) on legend to view only for the lab(s) selected</center></div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Labs Testing Trends <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="test_trends">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<!-- Map of the country -->
		<!-- Map of the country -->
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Labs Rejection Trends <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="rejected">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<!-- Map of the country -->
		
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    VLs Tested by Sample Type <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="samples">
			    <div>Loading...</div>
			  </div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    VLs Gender Breakdown <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="lab_gender">
			    <div>Loading...</div>
			  </div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    VLs Age Breakdown <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="lab_age">
			    <div>Loading...</div>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Turn around Time <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="ttime">
			    <div>Loading...</div>
			  </div>
			  
			</div>
		</div>
		
	</div>
	<div class="row">
		<!-- Map of the country -->
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Routine VLs Result Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="results">
			    <div>Loading...</div>
			  </div>
			</div>
		</div>
	</div>
</div>

<div id="second">
	<div class="row">
		<div id="lab_summary">
  
  		</div>
	</div>

	<div class="row">
		<div id="graphs">
  
  		</div>
	</div>	
</div>

<div id="third">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        Samples Rejections <div class="display_date"></div>
	      </div>
	      <div class="panel-body" id="lab_rejections">
	        <center><div class="loader"></div></center>
	      </div>
	    </div>
	  </div>
	</div>	
</div>

<div id="fourth">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        Rejections By Facilities <div class="display_date"></div>
	      </div>
	      <div class="panel-body" id="lab_facility_rejections">
	        <center><div class="loader"></div></center>
	      </div>
	    </div>
	  </div>
	</div>	
</div>

<div id="fifth">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        POC Stats <div class="display_date"></div>
	      </div>
	      <div class="panel-body" id="poc">
	        <center><div class="loader"></div></center>
	      </div>
	    </div>
	  </div>
	</div>	

	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
	    <div class="panel panel-default">
	      <div class="panel-heading">
	        POC Outcomes <div class="display_date"></div>
	      </div>
	      <div class="panel-body" id="poc_outcomes">
	        <center><div class="loader"></div></center>
	      </div>
	    </div>
	  </div>
	</div>	
</div>

<div id="empty_div"></div>
		

<?php $this->load->view('labs_summary_view_footer'); ?>