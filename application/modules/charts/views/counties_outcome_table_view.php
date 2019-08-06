<table cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered counties-tables" style="background:#CCC;" id="age_gender">
	<thead>
		<tr class="colhead">
			<th>No</th>
			<?php if(isset($subcountyListing)){?><th>Sub-County</th><?php } ?>
			<th >County</th>
			<th>Male Less than 2yrs-Tests</th>
			<th>Male Less than 2yrs &gt; 1000</th>
			<th>Male 2-9yrs-Tests</th>
			<th>Male 2-9yrs &gt; 1000</th>
			<th>Male 10-14yrs-Tests</th>
			<th>Male 10-14yrs &gt; 1000</th>
			<th>Male 15-19yrs-Tests</th>
			<th>Male 15-19yrs &gt; 1000</th>
			<th>Male 20-24yrs-Tests</th>
			<th>Male 20-24yrs &gt; 1000</th>
			<th>Male Above 25yrs-Tests</th>
			<th>Male Above 25yrs &gt; 1000</th>
			<th>Female Less than 2yrs-Tests</th>
			<th>Female Less than 2yrs &gt; 1000</th>
			<th>Female 2-9yrs-Tests</th>
			<th>Female 2-9yrs &gt; 1000</th>
			<th>Female 10-14yrs-Tests</th>
			<th>Female 10-14yrs &gt; 1000</th>
			<th>Female 15-19yrs-Tests</th>
			<th>Female 15-19yrs &gt; 1000</th>
			<th>Female 20-24yrs-Tests</th>
			<th>Female 20-24yrs &gt; 1000</th>
			<th>Female Above 25yrs-Tests</th>
			<th>Female Above 25yrs &gt; 1000</th>
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