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

<div class="row" id="first">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Partner Outcomes <div class="display_date"></div>
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
	
</div>
<?= @$this->load->view('partner/partner_pmtct__footer_view');?>