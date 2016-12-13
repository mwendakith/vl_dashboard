
<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
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
			<th>&gt; 1000 cp/ml</th>
			<th>% &gt; 1000 cp</th>
			<th>&lt; 1000 cp/ml</th>
			<th>%&lt;1000 cp/ml</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-12">
		<center><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;"></button></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable({
  		responsive: true
  	});

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });

    $("#download_link").html("<?php  echo $link; ?>");
  	$('#download_link > a').css("color","white");


  });
</script>