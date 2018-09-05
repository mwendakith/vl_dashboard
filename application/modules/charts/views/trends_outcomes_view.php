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
               opposite: true
    
            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
<<<<<<< HEAD
                    text: "<?= ($tat) ? 'Days': 'Tests'; ?>",
=======
                    text: "<?= ($tat) ? 'Days' : 'Tests'; ?>",
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
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
                align: 'right',
<<<<<<< HEAD
                verticalAlign: 'bottom',
                y: 24,
=======
                x: -50,
                verticalAlign: 'top',
                y: 30,
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
                floating: true,
                backgroundColor: '#FFFFFF'
            },colors: [
                        '#F2784B',
                        '#1BA39C',
                        '#257766'
                    ],
            series: <?php echo json_encode($trends['outcomes']);?>
        });
    });
    
</script>