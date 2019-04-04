

<div class="modal fade" tabindex="-1" role="dialog" id="poc_site_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> POC Site Details </h4>
      </div>
      <div class="modal-body">
        <table id="poc_site_table_details" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="max-width: 100%;">
        	<thead>
        		<tr>
        			<th>#</th>
              <th>Name</th>
              <th>MFL Code</th>
              <th>Tests</th>
              <th>Suppressed</th>
              <th>Suppression</th>
              <th>Adults</th>
              <th>Paeds</th>
              <th>Rejected</th>
        		</tr>
        	</thead>
        	<tbody>
        		<?= @$data['table']; ?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$("#poc_site_table_details").DataTable({
      // dom: 'Bfrtip',
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
    
    $("#poc_site_details").modal('show');

		// $("table").tablecloth({
		// 	theme: "paper",
		// 	striped: true,
		// 	sortable: true,
		// 	condensed: true
		// });
	});

</script>