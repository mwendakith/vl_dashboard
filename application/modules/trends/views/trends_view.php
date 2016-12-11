<div class="row">
  <div style="color:red;"><center>Click on Year(s) on legend to view only for the year(s) selected</center></div>
  <div id="graphs">
  
  </div>


  <div id="stacked_graph" class="col-md-6">

  </div>
</div>

  


<script type="text/javascript">

  $().ready(function() {
    $("#year-month-filter").hide();
    $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary");


    $("select").change(function(){
      var county_id = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_county_data", { county: county_id } );
      posting.done(function( data ) {
            $.get("<?php echo base_url();?>template/breadcrum/"+data, function(data){
              $("#breadcrum").html(data);
            });
      });

      $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/"+county_id);
      $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/"+county_id);
    });
  });
  
  $("select").change(function(){
    var county_id = $(this).val();

    $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/"+county_id);
    $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/"+county_id);
  });

  function get_graphs(year){
    $.ajax({
           url: "<?php echo base_url('charts/trends/positive_trends'); ?>/" + year,
           
           error: function(data) {
              $("#test").append(data);
           },
           dataType : "json",
           success: function(data) {
                
                
                $("#graphs").empty().append(data);
           },
           type: 'GET'
        });
  }

	
   
</script>