<div id="<?php echo $div_name; ?>"></div>

<script type="text/javascript">
	
    $(function () {
        $('#<?php echo $div_name; ?>').highcharts({
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            title: {
                text: "<?php echo $trends['title'];?>"
            },
            chart: {
                zoomType: 'xy'
            },
            xAxis: [{
                categories: <?php echo json_encode($trends['categories']);?>
            }],
            yAxis: {
                title: {
                    text: "<?php echo $trends['yAxis'];?>"
                }
            },

            tooltip: {
                borderRadius: 2,
                borderWidth: 1,
                borderColor: '#999',
                shadow: false,
                shared: true,
                useHTML: true,
                yDecimals: 0,
                valueDecimale: 0,
                headerFormat: '<table class="tip"><caption>{point.key}</caption>'+'<tbody>',
                pointFormat: '<tr><th style="color:{series.color}">{series.name}:</th>'+'<td style="text-align:right">{point.y}</td></tr>',
                footerFormat: '<tr><th>Total:</th>'+'<td style="text-align:right"><b>{point.total}</b></td></tr>'+'</tbody></table>'
            },
            legend: {
                layout: 'horizontal',
                align: 'left',
                x: 5,
                verticalAlign: 'bottom',
                y: 5,
                floating: false,
                width: $(window).width() - 20,
                // width: 1000,
                backgroundColor: '#FFFFFF'
            },
            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom',
                    y: -20
                }
            },
            colors: [
                '#F2784B',
                '#1BA39C',
                '#257766'
            ],
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
</script>