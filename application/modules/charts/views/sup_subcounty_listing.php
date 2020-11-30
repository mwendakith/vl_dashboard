<div class="list-group" style="height: 362px;">
	<?php echo $subCounty['ul'];?>
</div>
<button class="btn btn-primary"  onclick="expandSubListing();" style="background-color: #1BA39C;color: white; margin-top: 1em;margin-bottom: 1em;">View Full Listing</button>

<div class="modal fade" tabindex="-1" role="dialog" id="expSubList">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sub-County Listing</h4>
      </div>
      <div class="modal-body">
        <table id="subList" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
        			<th>Name</th>
        			<?php
                if(isset($countys['requests'])){
                  echo "<th># of Requests</th>";
                }else{
                  echo "<th>% Non-suppression</th>";
                }
              ?>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$subCounty['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#subList').DataTable({
			responsive: true
		});

		// $("table").tablecloth({
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});
	function expandSubListing()
	{
		$('#expSubList').modal('show');
	}
</script>