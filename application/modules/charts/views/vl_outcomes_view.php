<div id="vlOutcomes_pie" style="height: 350px;">

</div>
<script type="text/javascript">
	$(function () {
				$('#vlOutcomes_pie').highcharts({
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
		                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		            },
		            plotOptions: {
		                pie: {
		                    allowPointSelect: true,
		                    cursor: 'pointer',
		                    dataLabels: {
		                        enabled: false
		                    },
		                    showInLegend: true
		                }
		            },
		            series: [<?php echo json_encode($outcomes['vl_outcomes']); ?>]

		        });
		    });
</script>



