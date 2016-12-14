<div id="outcomes">

</div>

<script type="text/javascript">
    $(function () {
        $('#outcomes').highcharts({
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: '<?php echo $trends['title'];?>'
            },
            xAxis: [{
                categories: <?php echo json_encode($trends['categories']);?>
            }],
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
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 80,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
    
</script>