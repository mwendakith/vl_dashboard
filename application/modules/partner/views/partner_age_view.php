<style type="text/css">
	#age_dropdown{
		margin-bottom: 1em;
	}
</style>
<center>
	<div id="age_dropdown">
		<select class="btn btn-primary js-example-basic-single" style="background-color: #C5EFF7;" id="age_category" name="age_category">
	        <option value="0" disabled="true" selected="true">Select Age Category:</option>
	        <option value="NA">All Age Categories</option>
	        <!-- <optgroup value="Counties"> -->
	        <?php echo $age_filter; ?>
	        <!-- </optgroup> -->
	      </select>
	</div>
	<!-- <div> All Age Categories </div> -->
</center>
<div id="first">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    Age Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="age_outcomes">
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
			    Testing Trends <div class="display_range"></div>
			  </div>
			  <div class="panel-body" id="samples">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	VL Outcomes <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="vlOutcomes">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			  	Gender <div class="display_date" ></div>
			  </div>
			  <div class="panel-body" id="gender">
			  	<center><div class="loader"></div></center>
			  </div>
			  
			</div>
		</div>
	</div>
	<div class="row">
		<!-- Map of the country -->
		<!-- <div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading" id="heading">
			  	County Outcomes <div class="display_date"></div>
			  </div>
			  <div class="panel-body" id="county">
			    <center><div class="loader"></div></center>
			  </div>
			</div>
		</div> -->
	</div>

</div>


<?php $this->load->view('partner_age_view_footer');?>