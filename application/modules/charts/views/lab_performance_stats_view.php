<!-- <div id="download_link">
  
</div> -->

<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="/*background:#CCC;">
	<thead>
		<tr class="colhead">
			<th rowspan="2">No</th>
			<th rowspan="2">Testing Lab</th>
			<th rowspan="2">Facilities Serviced</th>
			<th rowspan="2">Total Samples Received</th>
			<th rowspan="2">Rejected Samples (on receipt at lab)</th>
			<th rowspan="2">Redraws (after testing)</th>
			<th rowspan="1">All Samples Run (plus reruns)</th>
			<th rowspan="2">Valid Test Results</th>
			<th rowspan="2">EQA QA/IQC Tests</th>
			<th rowspan="2">Confirmatory Repeat Tests</th>
			<th rowspan="2">Total Tests Performed</th>
			<th colspan="4"><center>Test Outcome(Non Suppressed vs Suppressed)</center></th>
		</tr>
		<tr>
			<th>Excludes QA and Repeats</th>
			<th>&gt; 1000 copies/ml</th>
			<th>% &gt; 1000 copies</th>
			<th>&lt; 1000 copies/ml</th>
			<th>%&lt;1000 copies/ml</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	// $('#download_link').html("<?php echo $link;?>");
  	$('#example').DataTable();

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });


  });
</script>