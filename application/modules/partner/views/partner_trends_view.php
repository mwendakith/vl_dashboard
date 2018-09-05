<div class="row">
<<<<<<< HEAD
  <div style="color:red;"><center>Click on Year(s) on legend to view only for the year(s) selected</center></div>
  <div id="stacked_graph" class="col-md-12">

  </div>
  
  <div id="graphs">
  
  </div>


  
</div>

  
=======

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
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6


<script type="text/javascript">

  $().ready(function() {
    $("#year-month-filter").hide();
<<<<<<< HEAD
    $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary");
=======
    $("#range").hide();
    $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends");
    $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary");
    $("#stacked_ages").load("<?php echo base_url();?>charts/partner_trends/age_summary");
    localStorage.setItem("my_var", 0);
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6


    $("select").change(function(){
      var partner_id = $(this).val();

      var posting = $.post( "<?php echo base_url();?>template/filter_partner_data", { partner: partner_id } );
      posting.done(function( data ) {
            $.get("<?php echo base_url();?>template/breadcrum/"+data+"/"+1, function(data){
              $("#breadcrum").html(data);
            });
      });
<<<<<<< HEAD

      $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends/"+partner_id);
      $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary/"+partner_id);
=======
      var a = localStorage.getItem("my_var");

      if(a == 0){
        $("#first").show();
        $("#second").hide();

        $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends/"+county_id);
        $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary/"+county_id);
      }
      else{
        $("#first").hide();
        $("#second").show();
        $("#q_outcomes").load("<?php echo base_url();?>charts/partner_trends/quarterly_outcomes/"+county_id);
        $("#q_graphs").load("<?php echo base_url();?>charts/partner_trends/quarterly/"+county_id);
      }
      
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
    });
  });
  
  $("select").change(function(){
    var partner_id = $(this).val();

    $("#graphs").load("<?php echo base_url();?>charts/partner_trends/positive_trends/"+partner_id);
    $("#stacked_graph").load("<?php echo base_url();?>charts/partner_trends/summary/"+partner_id);
  });

<<<<<<< HEAD
=======
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

>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
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