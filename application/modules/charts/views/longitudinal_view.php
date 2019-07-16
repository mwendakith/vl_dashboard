<!-- <div  style="margin-left:2em;"> -->
<div>

    <div id="<?php echo $div_name; ?>">

    </div>
    <p>
     Patients on Art as reported on DHIS as at <?php echo date('F', strtotime($trends['as_at'])) . ', ' . date('Y', strtotime($trends['as_at'])); ?>  - <?php echo number_format($trends['total_patients']) ; ?> <br />
     Total Unique Patients Tested - <?php echo number_format($trends['unique_patients']) ; ?> <br />

        <?php  
            for ($i=0; $i < $trends['size']; $i++) { 
                "No of patients with " . $trends['categories'][$i] . " tests - " . number_format($trends['outcomes'][0]['data'][$i]) . "<br />";
            }

        ?>
    Total tests - <?php echo number_format($trends['total_tests']) ; ?> <br />
    Coverage - <?php echo number_format($trends['coverage']) ; ?>% <br />
    </p>
</div>

<script type="text/javascript">
    $(function () {
        $('#<?php echo $div_name; ?>abc').highcharts({
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


        $('#<?php echo $div_name; ?>').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: {point.z} <b>({point.percentage:.1f} %)</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.z} ({point.percentage:.1f} %)',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    },
                    showInLegend: true
                }
            },
            series: [<?php echo json_encode([
                    'data' => [
                        [
                            'name' => 'Covered',
                            'y' => $trends['coverage'],
                            'z' => number_format($trends['unique_patients']),
                            'color' => '#66ff66',
                            'sliced' => true,
                            'selected' => true,
                        ],
                        [
                            'name' => 'Not Covered',
                            'y' => (100.0 - $trends['coverage']),
                            'z' => number_format($trends['total_patients'] - $trends['unique_patients']),
                            'color' => '#F2784B',
                        ],
                    ],
                ]); ?>]

        });



    });
    
</script>