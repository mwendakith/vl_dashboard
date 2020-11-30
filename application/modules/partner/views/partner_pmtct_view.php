<style type="text/css">
	.display_date {
		width: 130px;
		display: inline;
	}
	.display_range {
		width: 130px;
		display: inline;
	}
	#age_dropdown{
		margin-bottom: 1em;
	}
</style>
<center>
	<div id="age_dropdown">
		<select class="btn btn-primary js-example-basic-single" style="background-color: #C5EFF7;" id="partner_pmtct" name="partner_pmtct">
	        <option value="0" disabled="true" selected="true">Select PMTCT:</option>
            <option value="NA">All PMTCT</option>
            <!-- <optgroup value="Counties"> -->
            <?php echo $pmtcts; ?>
	        <!-- </optgroup> -->
	      </select>
	</div>
	<!-- <div> All Age Categories </div> -->
</center>
<div class="row" id="first">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partners Outcomes (Routine VL) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="partner_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<div class="row" id="second">
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	PMTCT Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_outcomes_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	PMTCT Suppression Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_sup_outcomes_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<div class="row" id="third">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	PMTCT Supperssion  (Routine VL) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_suppression_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	VL Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_vl_outcomes_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<!-- <div class="col-md-4 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Counties <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_counties_listing_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partners <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_partners_listing_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Sites <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_sites_listing_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div> -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partners PMTCT Outcomes (Routine VL) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_counties_outcomes_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<div class="row" id="fourth">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	PMTCT Supperssion  (Routine VL) <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_suppression_all_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	VL Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="pmtct_vl_outcomes_all_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
<?= @$this->load->view('partner/partner_pmtct__footer_view');?>