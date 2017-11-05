<div class="list-group" style="height: 362px;">
	<?php echo $cont['ul'];?>
</div>
<button class="btn btn-primary"  onclick="expand_modal(&quot;#<?= @$cont['div']; ?>&quot;);" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">View Full Listing</button>

<div class="modal fade" tabindex="-1" role="dialog" id="<?= @$cont['div']; ?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= @$cont['title']; ?></h4>
      </div>
      <div class="modal-body">
        <table id="<?= @$cont['table_div']; ?>" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
              <th>Name</th>
              <th>No Age Suppressed</th>
              <th>&lt;2 Suppressed</th>
              <th>2-9 Suppressed</th>
              <th>10-14 Suppressed</th>
              <th>15-19 Suppressed</th>
              <th>20-24 Suppressed</th>
              <th>25+ Suppressed</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$cont['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("#<?= @$cont['table_div']; ?>").DataTable({
      // dom: 'Bfrtip',
      dom: '<"btn btn-primary"B>lTfgtip',
			responsive: true,
      buttons : [
        {
          text:  'Export to Excel',
          extend: 'csvHtml5',
          title: 'Suppression Export'
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

  function call_expander(){
    var modal_name = "#<?= @$cont['div']; ?>";
    expand_modal(modal_name);
  }

</script>