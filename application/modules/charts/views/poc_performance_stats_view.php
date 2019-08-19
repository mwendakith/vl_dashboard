<div class="table-responsive">
	<table id="poc_table" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
		<thead>
			<tr class="colhead">
				<th>No</th>
				<th>Hub</th>
				<th>MFL</th>
				<th>Facilities Sending Samples</th>
				<th>Received Samples at Hub</th>
				<th>Rejected Samples (on receipt at Hub)</th>
				<th>All Test Done at Hub</th>
				<th>Redraw (after testing)</th>
				<th>Routine VL Tests</th>
				<th>Routine VL Tests &gt; 1000</th>
				<th>Baseline VL Tests</th>
				<th>Baseline VL Tests &gt; 1000</th>
				<th>Confirmatory Repeat Tests</th>
				<th>Confirmatory Repeat Tests &gt; 1000</th>
				<th>Total Tests with Valid Outcomes</th>
				<th>Total Tests &gt; 1000 with Valid Outcomes</th>
				<th>View Spoke Details</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $stats;?>
		</tbody>
	</table>
</div>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#poc_table').DataTable({
  		dom: '<"btn btn-primary"B>lTfgtip',
		responsive: false,
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