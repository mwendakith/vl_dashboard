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
</style>
<div class="row">
	
</div>
<div class="row">
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <!-- <span class="label label-success pull-right">Monthly</span> -->
		                <h5>Reeceived Samples</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">40 886,200</h1>
		                <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
		                <small>Total income</small> -->
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Inqueue Samples</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">406,200</h1>
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>In Process Samples</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">342,200</h1>
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Processed Samples</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">34,200</h1>
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Pending Approval</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">646,200</h1>
		            </div>
		        </div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Dispatched Results</h5>
		            </div>
		            <div class="ibox-content">
		                <h1 class="no-margins stat-percent font-bold text-success">98,200</h1>
		            </div>
		        </div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Sample Entry</h3>
			</div>
			<div class="panel-body">
				<div id="sampleEntry"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Sample Entry vs Received</h3>
			</div>
			<div class="panel-body">
				<div id="sampleEntryVsReceived"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Site Entry by Lab</h3>
			</div>
			<div class="panel-body">
				<div id="siteEntryLab"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Received Samples by Lab</h3>
			</div>
			<div class="panel-body">
				<div id="receivedSampleLab"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Inqueue Samples by Lab</h3>
			</div>
			<div class="panel-body">
				<div id="inqueueLabs"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">In process samples by Lab</h3>
			</div>
			<div class="panel-body">
				<div id="inprocessLabs"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Processed Samples</h3>
			</div>
			<div class="panel-body">
				<div id="processedSamples"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Pends Approval</h3>
			</div>
			<div class="panel-body">
				<div id="pendsApproval"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Dispatched Results</h3>
			</div>
			<div class="panel-body">
				<div id="dispatchedResults"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Oldest Samples in queue</h3>
			</div>
			<div class="panel-body">
				<div id="oldestSamples"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">In process platform</h3>
			</div>
			<div class="panel-body">
				<div id="inprocessPlatform"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Processed by Platform</h3>
			</div>
			<div class="panel-body">
				<div id="processedPlatform"></div>
			</div>
		</div>
	</div>
</div>