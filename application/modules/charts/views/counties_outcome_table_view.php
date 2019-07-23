<table cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered counties-tables" style="background:#CCC;" id="age_gender">
	<thead>
		<tr class="colhead">
			<th rowspan="3">No</th>
			<?php if(isset($subcountyListing)){?><th rowspan="3">Sub-County</th><?php } ?>
			<th rowspan="3">County</th>
			<th colspan="12">Male</th>
			<th colspan="12">Female</th>
		</tr>
		<tr>
			<th colspan="2">Less than 2yrs</th>
			<th colspan="2">2-9yrs</th>
			<th colspan="2">10-14yrs</th>
			<th colspan="2">15-19yrs</th>
			<th colspan="2">20-24yrs</th>
			<th colspan="2">Above 25yrs</th>
			<th colspan="2">Less than 2yrs</th>
			<th colspan="2">2-9yrs</th>
			<th colspan="2">10-14yrs</th>
			<th colspan="2">15-19yrs</th>
			<th colspan="2">20-24yrs</th>
			<th colspan="2">Above 25yrs</th>
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
  	// $('table').DataTable();

  	$('#age_gender').DataTable({
  		dom: '<"btn btn-primary"B>lTfgtip',
		responsive: false,
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