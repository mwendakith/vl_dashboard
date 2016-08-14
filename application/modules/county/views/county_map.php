
<div id="counties_map" style="height: 600px; " class="col-md-6">

</div>

<div id="table" class="col-md-6">
    <button onclick="retrieve_map('Tests', 'counties_tests', '');">Tests</option>
    <button onclick="retrieve_map('Suppressed', 'counties_suppressed', '%');">Suppressed</option>
    <button onclick="retrieve_map('Non Suppressed', 'counties_non_suppressed', '%');">Non Suppressed</option>
    <button onclick="retrieve_map('Rejected', 'counties_rejects', '%');">Rejected</option>
    <button onclick="retrieve_map('Pregnant Mothers', 'counties_pregnant', '');">Preganant mothers</option>
    <button onclick="retrieve_map('Lactating Mothers', 'counties_lactating', '');">Lactating mothers</option>
    

</div>

<div id="county_name" class="col-lg-12">

</div>

<div id="county_details" class="col-lg-12">

</div>

<script type="text/javascript">

    var year = 2016;
    var month = 0;
    function set_table(county_id, county_name){
        $("#county_details").empty().
        load("<?php echo base_url('charts/counties/county_details'); ?>/" + county_id);

        $("#county_name").empty().append("<br /><br /><h1>" + county_name + "</h1>");
    }

    // Uses the data to make the map
    function create_map(map_title, MapData, suffix){
        // Initiate the chart
        $('#counties_map').highcharts('Map', {
                title: {
                text: map_title + "<?php echo ' ' . $this->session->userdata('filter_month') . ' ' . 
                $this->session->userdata('filter_year'); ?>"
            },
             legend: {
                enabled: true
            },
            
            
            series: [
                {
                    "name" : map_title,
                    "type": "map",
                    "mapData": kenya_map,
                    "data" : MapData,
                    "joinBy": ['id', 'id'],
                    "dataLabels": {
                            enabled: true,
                            color: '#FFFFFF',
                            format: '{point.name}'
                        },
                    "point":{
                        "events":{
                            click: function(){
                                set_table(this.id, this.name);
                            }
                        }
                    },
                    "tooltip": {
                        "valueSuffix": suffix
                    }
                }
            ],

            colorAxis: {},

            mapNavigation: {
                enabled: true,
                enableButtons: true
            },
                      
          
          
       
        
        });
    }

    // Calls the counties model to retrieve map data
    function retrieve_map(map_title, func_path, suffix){

        $.ajax({
           url: "<?php echo base_url('charts/counties/'); ?>/" + func_path,
           
           error: function() {
              alert("Error");
           },
           dataType : "json",
           success: function(data) {
                var return_data = [];
                $.each(data, function(key, value){
                    return_data.push(value);
                });

                create_map(map_title, return_data, suffix);
                
                //$("#counties_map").append(data));
           },
           type: 'GET'
        });

    }

    function date_filter(criteria, id)
    {
        if (criteria === "monthly") {
            year = null;
            month = id;
        }else {
            year = id;
            month = null;
        }

        var posting = $.post( '<?php echo base_url();?>county/set_filter_date', { 'year': year, 'month': month } );

        // Put the results in a div
        posting.done(function( data ) {
            obj = $.parseJSON(data);
            
            if(obj['month'] == "null" || obj['month'] == null){
                obj['month'] = "";
            }
            $(".display_date").html("( "+obj['year']+" "+obj['month']+" )");

            alert(obj['month']);
            
        });
        
       
    }


    // Creates the default map
    $(function () {
    
        retrieve_map("Suppressed", "counties_suppressed", '%')

    });

</script>

