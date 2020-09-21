<div class="table-responsive">
	<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
		<thead>
			<tr class="colhead">
				<th>No</th>
				<th>Lab</th>
				<th>Facilities Sending Samples</th>
				<th>Received Samples at Lab</th>
				<th>Rejected Samples (on receipt at lab)</th>
				<th>All Test (plus reruns) Done at Lab</th>
				<th>Redraw (after testing)</th>
				<th>EQA Tests</th>
				<th>Controls Run</th>
				<th>Routine VL Tests</th>
				<th>Routine VL Tests &gt; 1000</th>
				<th>Baseline VL Tests</th>
				<th>Baseline VL Tests &gt; 1000</th>
				<th>Confirmatory Repeat Tests</th>
				<th>Confirmatory Repeat Tests &gt; 1000</th>
				<th>Confirmatory Repeat Tests Without Previous Nonsuppressed</th>
				<th>Total Tests with Valid Outcomes</th>
				<th>Total Tests &gt; 1000 with Valid Outcomes</th>
			</tr>
			
		</thead>
		<tbody>
			<?php echo $stats;?>
		</tbody>
	</table>
</div>
<div class="row" style="display: none;">
	<div class="col-md-12">
		<center><a href="<?php echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable({
  		dom: '<"btn btn-primary"B>lTfgtip',
  		pageLength: 50,
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