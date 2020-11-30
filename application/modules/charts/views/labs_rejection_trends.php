<div id="rejecting_trends">
    
</div>

<script type="text/javascript">
    $(function () {
        $('#rejecting_trends').highcharts({
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Rejection (%)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: "%"
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'center',
                borderWidth: 0
            },
            series: <?php echo json_encode($trends['reject_trend']);?>
        });
    });
</script>