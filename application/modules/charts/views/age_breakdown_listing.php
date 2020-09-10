<?php
  $function = 'expandSiteListing'.$outcomes['modal_name'];
?>
<div class="list-group" style="height: 362px;">
	<?php echo $outcomes['ul'];?>
</div>
<button class="btn btn-primary"  onclick="<?= @$function;?>();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">View Full Listing</button>

<div class="modal fade" tabindex="-1" role="dialog" id="<?php echo $outcomes['modal_name'];?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Full Listing</h4>
      </div>
      <div class="modal-body">
        <table id="<?php echo $outcomes['div_name'];?>" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
        			<th>Name</th>
        			<th>Tests</th>
              <th>Suppressed</th>
              <th>Non - Suppressed</th>
              <th>Suppression</th>
              <?php  
                if(isset($is_counties)) echo "<th>Male Test </th><th>Male > 1000 </th><th>Female Test </th><th>Female > 1000 </th> ";
              ?>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$outcomes['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $outcomes['div_name'];?>").DataTable({
      dom: '<"btn btn-primary"B>lTfgtip',
      responsive: true,
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
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});
	function <?= @$function;?>()
	{
		$('#<?php echo $outcomes['modal_name'];?>').modal('show');
	}
</script>