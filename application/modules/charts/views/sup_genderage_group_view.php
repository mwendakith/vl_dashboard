<div id="genderGroup_pie">
	
</div>
<script type="text/javascript">
	$(function () {
    // Age categories
		    var categories = ['0-4', '5-9', '10-14', '15-17', '18+'];
		    $(document).ready(function () {
		        $('#genderGroup_pie').highcharts({
		            chart: {
		                type: 'bar'
		            },
		            title: {
		                text: 'No suppression in age groups and gender'
		            },
		            xAxis: [{
		                categories: categories,
		                reversed: false,
		                labels: {
		                    step: 1
		                }
		            }, { // mirror axis on right side
		                opposite: true,
		                reversed: false,
		                categories: categories,
		                linkedTo: 0,
		                labels: {
		                    step: 1
		                }
		            }],
		            yAxis: {
		                title: {
		                    text: null
		                },
		                labels: {
		                    formatter: function () {
		                        return Math.abs(this.value) + '%';
		                    }
		                }
		            },

		            plotOptions: {
		                series: {
		                    stacking: 'normal'
		                }
		            },

		            tooltip: {
		                formatter: function () {
		                    return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
		                        'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
		                }
		            },

		            series: [{
		                name: 'Male',
		                data: [-2.2, -2.2, -2.3, -2.5, -2.7]
		            }, {
		                name: 'Female',
		                data: [2.1, 2.0, 2.2, 2.4, 2.6]
		            }]
		        });
		    });

		});
</script>