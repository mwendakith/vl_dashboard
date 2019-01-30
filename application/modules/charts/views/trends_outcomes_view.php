<div id="<?php echo $div_name; ?>">

</div>

<script type="text/javascript">
    $(function () {
        $('#<?php echo $div_name; ?>').highcharts({
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
                <?= ($interval) ? "tickInterval: $interval," : ''; ?>
                opposite: true
    
            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: "<?= ($tat) ? 'Days' : 'Tests'; ?>",
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
                layout: 'horizontal',
                align: 'right',
                x: -35,
                verticalAlign: 'bottom',
                y: 5,
                floating: false,
                backgroundColor: '#FFFFFF'
            },
            colors: [
                        '#F2784B',
                        '#1BA39C',
                        '#257766'
                    ],
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
    
</script>