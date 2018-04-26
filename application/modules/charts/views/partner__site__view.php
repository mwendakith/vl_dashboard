<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">No</th>
			<th rowspan="2">County</th>
			<th rowspan="2">Facilities Sending Samples</th>
			<th rowspan="2">Received Samples at Lab</th>
			<th rowspan="2">Rejected Samples (on receipt at lab)</th>
			<th rowspan="2">All Test (plus reruns) Done at Lab</th>
			<th rowspan="2">Redraw (after testing)</th>
			<th colspan="2">Routine VL Tests</th>
			<th colspan="2">Baseline VL Tests</th>
			<th colspan="2">Confirmatory Repeat Tests</th>
			<th colspan="2">Total Tests with Valid Outcomes</th>
			<th colspan="2">Female</th>
			<th colspan="2">Male</th>
			<th colspan="2">No Data</th>
			<th colspan="2">Less 2 Yrs</th>
			<th colspan="2">2 - 9 Yrs</th>
			<th colspan="2">10 - 14 yrs</th>
			<th colspan="2">15 - 19 yrs</th>
			<th colspan="2">20- 24 yrs</th>
			<th colspan="2">Above 25 yrs</th>
		</tr>
		<tr>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
			<th>Tests</th>
			<th>&gt; 1000</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<div class="row" id="excels" style="display: none;">
	<div class="col-md-6">
		<!-- <center><button class="btn btn-primary" style="background-color: #009688;color: white;">List of all supported sites</button></center> -->
	</div>
	<div class="col-md-6">
		<center><a href="<?php  echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {

  	$('#example').DataTable({
  		dom: '<"btn btn-primary"B>lTfgtip',
		responsive: true,
	    buttons : [
	        {
	          text:  'Export to CSV',
	          extend: 'csvHtml5',
	          title: 'Download'
	        },
	        {
	          text:  'Export to Excel',
	          extend: 'excelHtml5',
	          title: 'Download'
	        }
	      ]
  	});

    // $("table").tablecloth({
    //   theme: "paper",
    //   striped: true,
    //   sortable: true,
    //   condensed: true
    // });
  });
</script>