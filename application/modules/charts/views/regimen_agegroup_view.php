<div id="<?=  @(isset($div_name) ? $div_name: 'ageGroups_pie') ?>" style="height:450px;">
	
</div>
<script type="text/javascript">
	$(function () {
                $('#ageGroups_pie').highcharts({
                    chart: {
                        type: 'column'
                    },
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        categories: <?php echo json_encode($outcomes['categories']);?>
                    },
                    yAxis: [{ // Primary yAxis
                        labels: {
                            formatter: function() {
                                return this.value +'%';
                            },
                            style: {
                                color: '#89A54E'
                            }
                        },
                        title: {
                            text: 'Percentage',
                            style: {
                                color: '#89A54E'
                            }
                        },
                       opposite: true
            
                    }, { // Secondary yAxis
                        gridLineWidth: 0,
                        title: {
                            text: 'Tests',
                            style: {
                                color: '#4572A7'
                            }
                        },
                        labels: {
                            formatter: function() {
                                return this.value +'';
                            },
                            style: {
                                color: '#4572A7'
                            }
                        }
                        // min: 0, 
                        // max: 70000,
                        // tickInterval: 1
                    }],

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
                        shared: true,
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/> contribution: {point.percentage:.1f}%'
                    },colors: [
                        '#F2784B',
                        '#1BA39C',
                        '#257766'
                    ],
                    series: <?php echo json_encode($outcomes['ageGnd']);?>
                });
            });
</script>