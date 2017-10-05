<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th>#</th>
			<th>MFL Code</th>
			<th>Name</th>
			<th>County</th>
			<th>Tests</th>
			<th>&gt; 1000 cp/ml</th>
			<th>Confirm Repeat Tests</th>
			<th>Rejected</th>
			<th>Adult Tests</th>
			<th>Paeds Tests</th>
			<th>Male</th>
			<th>Female</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<div class="row" id="excels">
	<div class="col-md-6">
		<!-- <center><button class="btn btn-primary" style="background-color: #009688;color: white;">List of all supported sites</button></center> -->
	</div>
	<div class="col-md-6">
		<center><a href="<?php  echo $link; ?>"><button id="download_link" class="btn btn-primary" style="background-color: #009688;color: white;">Export To Excel</button></a></center>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable();

    // $("table").tablecloth({
    //   theme: "paper",
    //   striped: true,
    //   sortable: true,
    //   condensed: true
    // });
  });
</script>