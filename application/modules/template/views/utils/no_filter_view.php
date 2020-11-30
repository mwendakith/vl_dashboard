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

  
  <div class="col-md-3">

  </div>
  <div class="col-md-1">
    <div id="breadcrum" class="alert" style="background-color: #1BA39C;display:none;">
      
    </div>
  </div>
  
  <div class="col-md-5 " id="year-month-filter">
    <div class="filter">
      Year: 
      <?php
        for ($i=9; $i > -1; $i--) { 
          $year = gmdate('Y');
          $year -= $i;
      ?>
      <a href="javascript:void(0)" onclick="date_filter('yearly', <?= @$year; ?> )" class="alert-link"> <?= @$year; ?> </a>|
      <?php } ?>
    </div>
    <div class="filter">
      Month: 
      <a href='javascript:void(0)' onclick='date_filter("monthly", "all")' class="alert-link"> All </a>|
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
    $(".js-example-basic-single").select2();
    
  });
</script>