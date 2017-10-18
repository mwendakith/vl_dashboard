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

<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Tests done by unique patients <div class="display_date"></div>
		  </div>
		  <div class="panel-body" id="long_tracking">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
		    Suppression Rate <div class="display_current_range"></div>
		  </div>
		  <div class="panel-body" id="current_sup">
		    <center><div class="loader"></div></center>
		  </div>
		</div>
	</div>
</div>

<?php $this->load->view('current_view_footer'); ?>