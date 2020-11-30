<div id="sampletypes">
	
</div>
<script type="text/javascript">
	$(function () {
	    $('#sampletypes').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: ''
	        },
	        xAxis: {
	            categories: <?php echo json_encode($trends['categories']);?>
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Sample Types'
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
                verticalAlign: 'bottom',
                floating: false,
	            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
	            borderColor: '#CCC',
	            borderWidth: 1,
	            shadow: false
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
				        '#52B3D9',
				        '#E26A6A',
				        '#913D88'
				    ],
	        series: <?php echo json_encode($trends['sample_types']);?>
	    });
	});
</script>