<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}
.date-picker {
    width: 100px;
    margin-right: 0.5em;
    font-size: 11px;
}
.date-pickerBtn {
    /*width: 80px;*/
    font-size: 11px;
    height: 22px;
}
.filter {
    font-size: 11px;
}
#breadcrum {
    font-size: 11px;
}
#errorAlert {
    font-size: 11px;
    background-color: #E08283;
    color: #96281B;
}
</style>
<div class="row" id="filter">
  <div class="col-md-2">
    <form action="<?php echo base_url();?>template/filter_county_data" method="post" id="filter_form">
      <div class="row">
        <div class="col-md-6">
          <select class="btn btn-primary js-example-basic-multiple" style="background-color: #C5EFF7;" id="age" name="age[]" multiple="multiple" data-placeholder="Select Age Category:">
            <option value="48">All Age Categories</option>
            <!-- <optgroup value="Counties"> -->
            <?php echo $age_filter; ?>
            <!-- </optgroup> -->
          </select>
        </div>
        
      </div>
      
      
    </form>
  </div>
  <div class="col-md-2">
    <div id="breadcrum" class="alert" style="background-color: #1BA39C;display:none;">
      
    </div>
  </div>
  <div class="col-md-5" id="year-month-filter">
    <div class="filter">
      Year: 
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2010 )" class="alert-link"> 2010 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2011 )" class="alert-link"> 2011 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2012 )" class="alert-link"> 2012 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2013 )" class="alert-link"> 2013 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2014 )" class="alert-link"> 2014 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2015 )" class="alert-link"> 2015 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2016 )" class="alert-link"> 2016 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2017 )" class="alert-link"> 2017 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2018 )" class="alert-link"> 2018 </a>
    </div>
    <div class="filter">
      Month: 
      <a href='javascript:void(0)' onclick='date_filter("monthly", 1)' class='alert-link'> Jan </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 2)' class='alert-link'> Feb </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 3)' class='alert-link'> Mar </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 4)' class='alert-link'> Apr </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 5)' class='alert-link'> May </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 6)' class='alert-link'> Jun </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 7)' class='alert-link'> Jul </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 8)' class='alert-link'> Aug </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 9)' class='alert-link'> Sep </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 10)' class='alert-link'> Oct </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 11)' class='alert-link'> Nov </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 12)' class='alert-link'> Dec</a>
    </div>
  </div>

  <div class="col-md-2">
      <div class="row" id="range">
          <div class="col-md-4">
              <input name="startDate" id="startDate" class="date-picker" placeholder="From:" />
          </div>
          <div class="col-md-4 endDate">
              <input name="endDate" id="endDate" class="date-picker" placeholder="To:" />
          </div>
          <div class="col-md-4">
              <button id="filter" class="btn btn-primary date-pickerBtn" style="color: white;background-color: #1BA39C; margin-top: 0.2em; margin-bottom: 0em; margin-left: 4em;"><center>Filter</center></button>
          </div>
      </div>
          <center><div id="errorAlertDateRange"><div id="errorAlert" class="alert alert-danger" role="alert">...</div></div></center>
  </div>

</div>
<script type="text/javascript">
  $(function() {
    $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
    $('#endDate').datepicker( {
        changeMonth: true,
        changeYear: false,
        showButtonPanel: true,
        dateFormat: 'MM',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            // var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(month, 1));
        }
    });
  });
  
  $().ready(function(){
    $('#errorAlertDateRange').hide();
    $(".js-example-basic-multiple").select2();
    //Getting the URL dynamically
    // var url = $(location).attr('href');
    // // Getting the file name i.e last segment of URL (i.e. example.html)
    // var fn = url.split('/').indexOf("partner");
    // // console.log(fn);
    
    // if (fn==-1) {
    //   $.get("<?php echo base_url();?>template/breadcrum", function(data){
    //     $("#breadcrum").html(data);
    //   });
    // } else {
    //   $.get("<?php echo base_url();?>template/breadcrum", function(data){
    //     $("#breadcrum").html(data);
    //   });
    // }
    
  });
<<<<<<< HEAD
</script>

=======
</script>
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
