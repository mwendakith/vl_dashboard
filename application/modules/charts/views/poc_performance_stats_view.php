<div class="table-responsive">
	<table id="poc_table" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
		<thead>
			<tr class="colhead">
				<th rowspan="2">No</th>
				<th rowspan="2">Facility</th>
				<th rowspan="2">MFL</th>
				<th rowspan="2">Facilities Sending Samples</th>
				<th rowspan="2">Received Samples at Lab</th>
				<th rowspan="2">Rejected Samples (on receipt at lab)</th>
				<th rowspan="2">All Test (plus reruns) Done at Lab</th>
				<th rowspan="2">Redraw (after testing)</th>
				<th colspan="2">Routine VL Tests</th>
				<th colspan="2">Baseline VL Tests</th>
				<th colspan="2">Confirmatory Repeat Tests</th>
				<th colspan="2">Total Tests with Valid Outcomes</th>
				<th rowspan="2">View Details</th>
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

	function expand_poc(facility_id)
	{
		var year = localStorage.getItem("from_year");
		var month = localStorage.getItem("from_month");

		var to_year = localStorage.getItem("to_year");
		var to_month = localStorage.getItem("to_month");

		$("#empty_div").load("<?php echo base_url();?>charts/labs/results_outcome/"+facility_id+"/"+year+"/"+month+"/"+to_year+"/"+to_month);
	}

</script>