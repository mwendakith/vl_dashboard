
<?php
    echo "<div id=" . $div_name . " class='col-md-6'>

</div>";

?>


<script type="text/javascript">

  
    $("#<?php echo $div_name; ?>").highcharts({
        title: {
            text: "<?php echo $title; ?>",
            x: -20 //center
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: "<?php echo $yAxis; ?>"
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: "<?php echo $suffix; ?>",

        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            floating: true,
            borderWidth: 0
        },
        series: <?php echo json_encode($trends);?>
            
    });
  

 
</script>