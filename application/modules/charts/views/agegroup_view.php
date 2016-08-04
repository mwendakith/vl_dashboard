<div id="ageGroups_pie">
	
</div>
<div>
    <ul>
        <?php echo $outcomes['ul'];?>
    </ul>
</div>
<script type="text/javascript">
	$(function () {
    console.log(Highcharts.getOptions());
    var colors = Highcharts.getOptions().colors,
        categories = ['Adults', 'Children'],
        data = <?php echo json_encode($outcomes['ageGnd'])?>,
        agecategories = [],
        agegroups = [],
        i,
        j,
        dataLen = data.length,
        drillDataLen,
        brightness;


    // Build the data arrays
    for (i = 0; i < dataLen; i += 1) {

        // add agecategories data
        agecategories.push({
            name: categories[i],
            y: data[i].y,
            color: data[i].color
        });

        // add agegroups data
        drillDataLen = data[i].drilldown.data.length;
        for (j = 0; j < drillDataLen; j += 1) {
            brightness = 0.2 - (j / drillDataLen) / 5;
            agegroups.push({
                name: data[i].drilldown.categories[j],
                y: data[i].drilldown.data[j],
                color: Highcharts.Color(data[i].color).brighten(brightness).get()
            });
        }
    }

    // Create the chart
    $('#ageGroups_pie').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            pie: {
                shadow: false,
                center: ['50%', '50%']
            }
        },
        tooltip: {
            valueSuffix: null,
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        series: [{
            name: 'Age Categories',
            data: agecategories,
            size: '60%',
            dataLabels: {
                formatter: function () {
                    return this.y > 5 ? this.point.name : null;
                },
                color: '#ffffff',
                distance: -30
            }
        }, {
            name: 'Age Group',
            data: agegroups,
            size: '80%',
            innerSize: '60%',
            dataLabels: {
                formatter: function () {
                    // display only if larger than 1
                    return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + '' : null;
                }
            }
        }]
    });
});
</script>