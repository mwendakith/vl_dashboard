<div style="width: 540px;">
	<p>
		Total Patients : <?php echo $patients; ?>  <br />
		Total VL done : <?php echo $tests; ?>  <br />
		Unmet Need : <?php echo $unmet; ?>%  <br />

	</p>


	<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
		<thead>
			<tr class="colhead">
				<th>Total Tests</th>
				<th>1 VL</th>
				<th>2 VL</th>
				<th>3 VL</th>
				<th>> 3 VL</th>
			</tr>
			
		</thead>
		<tbody>
			<?php echo $stats;?>
		</tbody>
	</table>
</div>