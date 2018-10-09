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
	<!-- Map of the country -->
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		  	Agencies Outcomes <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="agency_div">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>
		
<?php $this->load->view('partner_agencies_view_footer'); ?>