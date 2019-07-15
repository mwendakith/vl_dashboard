<div  style="margin-left:2em;">
    <p>
     Patients on Art as reported on DHIS as at <?php echo date('F', strtotime($trends['as_at'])) . ', ' . date('Y', strtotime($trends['as_at'])); ?>  - <?php echo number_format($trends['total_patients']) ; ?> <br />
     Total Unique Patients Tested - <?php echo number_format($trends['unique_patients']) ; ?> <br />

        <?php  
            for ($i=0; $i < $trends['size']; $i++) { 
                echo "No of patients with " . $trends['categories'][$i] . " tests - " . number_format($trends['outcomes'][0]['data'][$i]) . "<br />";
            }

        ?>
    Total tests - <?php echo number_format($trends['total_tests']) ; ?> <br />
    Coverage - <?php echo number_format($trends['coverage']) ; ?>% <br />
    </p>

    <div id="<?php echo $div_name; ?>">

    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#<?php echo $div_name; ?>').highcharts({
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            chart: {
                type: 'column'
            },
            title: {
                text: "<?php echo $trends['title'];?>"
            },
            xAxis: {
                categories: <?php echo json_encode($trends['categories']);?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Tests'
                },
                stackLabels: {
                    rotation: 0,
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    },
                    y:-10
                }
            },
            legend: {
                layout: 'horizontal',
                align: 'left',
                x: 5,
                verticalAlign: 'bottom',
                y: 5,
                floating: false,
                width: $(window).width() - 20,
                backgroundColor: '#FFFFFF'
            },
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
    
</script>