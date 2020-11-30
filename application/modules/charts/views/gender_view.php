<div id="gender_pie" style="height:540px;">

</div>

<script type="text/javascript">
	 $(function () {
                $('#gender_pie').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: <?php echo json_encode($outcomes['categories']);?>
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
                        x: -30,
                        verticalAlign: 'bottom',
                        y: 0,
                        floating: false,
                        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                        borderColor: '#CCC',
                        borderWidth: 1,
                        shadow: true
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>% contribution: {point.percentage:.1f}%'
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
                        '#F2784B',
                        '#1BA39C'
                    ],
                    series: <?php echo json_encode($outcomes['gender']);?>
                });
            });
</script>