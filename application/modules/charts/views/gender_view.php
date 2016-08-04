<div id="gender_pie">

</div>
<div>
    <ul>
        <?php echo $outcomes['ul'];?>
    </ul>
</div>
<script type="text/javascript">
	 $(function () {
			    $('#gender_pie').highcharts({
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
		            },colors: [
				        '#1BA39C',
				        '#F2784B'
				    ],
		            series: [<?php echo json_encode($outcomes['gender']); ?>]
		        });
		    });
</script>