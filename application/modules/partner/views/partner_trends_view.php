<div class="row">

  <div class="col-md-4 col-md-offset-4">
    <div id="breadcrum" class="alert" style="background-color: #1BA39C;text-align: center;vertical-align: middle;" onclick="switch_source()">
          <span id="current_source">Click to toggle between quarterly and yearly</span>   
      </div>
         
  </div>
</div> 

<div class="row">
  <div style="color:red;"><center>Click on Year(s)/Quarter(s) on legend to view only for the year(s)/quarter(s) selected</center></div>

  <div id="first">

    <div id="stacked_graph" class="col-md-12">

    </div>

    <div id="stacked_ages" class="col-md-12">

    </div>
    
    <div id="graphs">
    
    </div>

  </div>

  <div id="second">

    <div id="q_outcomes" class="col-md-12">
    
    </div>
    
    <div id="q_graphs">
    
    </div>

  </div>
  
</div>  


<script type="text/javascript">

  $().ready(function() {
    $("#year-month-filter").hide();
    $("#range").hide();
    $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary");
    $("#stacked_ages").load("<?php echo base_url();?>charts/partner_trends/age_summary");
    localStorage.setItem("my_var", 0);


    $("select").change(function(){
      var partner_id = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: partner_id } );
      posting.done(function( data ) {
            $.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
              $("#breadcrum").html(data);
            });
      });
      var a = localStorage.getItem("my_var");

      if(a == 0){
        $("#first").show();
        $("#second").hide();

        $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends/"+partner_id);
        $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary/"+partner_id);
      }
      else{
        $("#first").hide();
        $("#second").show();
        $("#q_outcomes").load("<?php echo base_url();?>charts/partner_trends/quarterly_outcomes/"+partner_id);
        $("#q_graphs").load("<?php echo base_url();?>charts/partner_trends/quarterly/"+partner_id);
      }
      
    });
  });
  
  $("select").change(function(){
    var partner_id = $(this).val();

    $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends/"+partner_id);
    $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary/"+partner_id);
  });

  function switch_source(){
    var a = localStorage.getItem("my_var");

    if(a == 0){
      localStorage.setItem("my_var", 1);
      $("#first").hide();
      $("#second").show();
      $("#q_outcomes").load("<?php echo base_url();?>charts/trends/quarterly_outcomes/");
      $("#q_graphs").load("<?php echo base_url();?>charts/trends/quarterly/");
    }
    else{
      localStorage.setItem("my_var", 0);
      $("#first").show();
      $("#second").hide();

      $("#graphs").load("<?php echo base_url();?>charts/trends/positive_trends/");
      $("#stacked_graph").load("<?php echo base_url();?>charts/trends/summary/");
    }
  }

  function get_graphs(year){
    $.ajax({
           url: "<?php echo base_url('charts/partner_trends/positive_trends'); ?>/" + year,
           
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