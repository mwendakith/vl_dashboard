<??>
<div id="sampleType_pie">
	
</div>
<script type="text/javascript">
	$(function(){
				$('#sampleType_pie').highcharts({
				                chart: {
			            type: 'column'
			        },
			        title: {
			            text: ''
			        },
			       xAxis: {
			            categories: [ 'EDTA', 'Plasma', 'DBS' ],
			            crosshair: true
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Samples'
			            }
			        },
			        tooltip: {
			            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			            footerFormat: '</table>',
			            shared: true,
			            useHTML: true
			        },
			        plotOptions: {
			            column: {
			                pointPadding: 0.2,
			                borderWidth: 0
			            }
			        },
			        series: [{
			            name: 'Sample Types',
			            data: [49.9, 71.5, 106.4]

			        }]
			    });
			});
</script>