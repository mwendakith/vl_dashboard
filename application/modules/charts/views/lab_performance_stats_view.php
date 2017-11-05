
<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">No</th>
			<th rowspan="2">Lab</th>
			<th rowspan="2">Facilities Sending Samples</th>
			<th rowspan="2">Received Samples at Lab</th>
			<th rowspan="2">Rejected Samples (on receipt at lab)</th>
			<th rowspan="2">All Test (plus reruns) Done at Lab</th>
			<th rowspan="2">Redraw (after testing)</th>
			<th rowspan="2">EQA QA/IQC Tests</th>
			<th colspan="2">Routine VL Tests</th>
			<th colspan="2">Baseline VL Tests</th>
			<th colspan="2">Confirmatory Repeat Tests</th>
			<th colspan="2">Total Tests with Valid Outcomes</th>
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
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
<div class="row" style="display: none;">
	<div class="col-md-12">
		<center><a href="<?php echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
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
	          title: 'Lab Performance'
	        },
	        {
	          text:  'Export to Excel',
	          extend: 'excelHtml5',
	          title: 'Lab Performance'
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