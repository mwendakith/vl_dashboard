<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<?= @$th; ?>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
  	  	$('#example').DataTable({
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
	});
</script>