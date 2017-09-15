<p style="height: 200px;">
	Total Patients : <?php echo number_format($patients); ?>  <br />
	Total Viral Loads Done : <?php echo number_format($tests); ?>  <br />

</p>

<div style="height: 340px;">
<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
	<thead>
		<tr class="colhead">
			<th>Total Viral Load Tests</th>
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