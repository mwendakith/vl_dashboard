<??>
<div id="regimen_pie">
	
</div>
<script type="text/javascript">
	$(function(){
				$('#regimen_pie').highcharts({
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
			            series: [{
			                name: 'Justifications',
			                colorByPoint: true,
			                data: [{
			                    name: 'Routine VL',
			                    y: 56.33
			                }, {
			                    name: 'Confirmation of treatment Failure',
			                    y: 24.03,
			                    sliced: true,
			                    selected: true
			                }, {
			                    name: 'Clinical Failure',
			                    y: 56.33
			                }, {
			                    name: 'Immunological Failure',
			                    y: 24.03,
			                    sliced: true,
			                    selected: true
			                }, {
			                    name: 'Single Drug Substitution',
			                    y: 56.33
			                }, {
			                    name: 'Pregnant Mother',
			                    y: 24.03,
			                    sliced: true,
			                    selected: true
			                }, {
			                    name: 'Other',
			                    y: 56.33
			                }, {
			                    name: 'No Data',
			                    y: 24.03,
			                    sliced: true,
			                    selected: true
			                },  {
			                    name: 'Lactating Mothers',
			                    y: 56.33
			                }, {
			                    name: 'Baseline',
			                    y: 24.03,
			                    sliced: true,
			                    selected: true
			                }]
			            }]
			        });
		    });
</script>