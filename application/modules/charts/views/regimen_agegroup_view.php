<div id="<?php echo $div_name; ?>" style="height:450px;">
	
</div>
<script type="text/javascript">
    $(function () {
                $('#<?php echo $div_name; ?>').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: <?php echo json_encode($outcomes['categories']);?>,
                        crosshair: true
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
                        align: 'right',
                        verticalAlign: 'bottom',
                        floating: false,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: true
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
                        // formatter: function() {
                        //  return this.value;
                        // }
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            dataLabels: {
                                enabled: false,
                                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                style: {
                                    textShadow: '0 0 3px black'
                                }
                            }
                        }
                    },colors: [
                        '#52B3D9',
                        '#E26A6A',
                        '#913D88'
                    ],
                    series: <?php echo json_encode($outcomes['ageGnd']);?>
                });
            });
</script>