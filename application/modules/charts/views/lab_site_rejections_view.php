
<table id="site_rejections" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
	<thead>
		<tr class="colhead">
			<th>No</th>
			<th>Facility</th>
			<th>Rejected Reason</th>
			<th>Rejected Samples</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $stats;?>
	</tbody>
</table>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#site_rejections').DataTable({
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