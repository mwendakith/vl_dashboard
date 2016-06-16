<div id="sample_types">

</div>
<script type="text/javascript">
	$(function () {
			    $('#sample_types').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: ''
			        },
			        xAxis: {
			            categories:<?php echo json_encode($outcomes['categories'])?>,
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Tests'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'right',
			            x: -30,
			            verticalAlign: 'top',
			            y: 25,
			            floating: true,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false
			        },
			        tooltip: {
			            headerFormat: '<b>{point.x}</b><br/>',
			            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black'
			                    }
			                }
			            }
			        },colors: [
				        '#D91E18',
				        '#1BBC9B',
				        '#4183D7'
				    ],
			        series: <?php echo json_encode($outcomes['sample_types'])?>
			    });
			});
</script>