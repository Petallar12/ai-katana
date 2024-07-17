<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Dataloki</title>

        <style>
            :root {
                --white: #ffffff;
                --snow: #fafafa;
                --font-dark: #3b3b3b;
                --purple: #5046e5;
                --dark-purple: #392fc2;
            }

            * {
                font-family: 'Poppins', sans-serif;
                padding: 0;
                margin: 0;
                color: var(--font-dark);
            }

            #container {
                padding: 20px 20px 0;
                height: 500px;
            }

            li {
                list-style: none;
            }

            a {
                text-decoration: none;
                font-size: 9px;
                text-align: center;
                text-transform: uppercase;
                display: block;
            }

            a:hover {
                color: var(--purple);
                font-weight: 500;
                transition: color 250ms cubic-bezier(0.4, 0, 0.2, 1);
            }
        </style>

        <script src="{{ asset('js/highcharts.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <div id="container"></div>
        </div>
        <script type="text/javascript">
            var source = <?php echo json_encode($source) ?>;
            var countsource = source.map(function(obj) {
                return obj.count;
            });
            var categories = <?php echo json_encode($array) ?>;

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: "Number of Policy per Main Applicant's Age"
                },
                xAxis: {
                    categories: categories,
                    labels: {
                        useHTML: true,
                        formatter: function() {
                            var url = '/2024/dashboard_index/age_index?age=' + encodeURIComponent(this.value);
                            return '<a href="' + url + '">' + this.value + '</a>';
                        },
                        style: {
                            textAlign: 'center',
                            whiteSpace: 'wrap'
                        }
                    }
                },
                yAxis: [{
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                }],
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var tooltip = '<b>' + this.x + '</b>';
                        this.points.forEach(function(point) {
                            tooltip += '<br/>' + point.series.name + ': ' + Highcharts.numberFormat(point.y, 0, '.', ',');
                        });
                        return tooltip;
                    }
                },
                plotOptions: {
                    column: {
                        color: 'var(--purple)',
                        dataLabels: {
                            enabled: true,
                            inside: false,
                            formatter: function() {
                                return this.y > 0 ? Highcharts.numberFormat(this.y, 0, '.', ',') : null;
                            },
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textOutline: '2px contrast',
                                textAlign: 'center'
                            }
                        }
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    var url = '/2024/dashboard_index/age_index?age=' + encodeURIComponent(this.category);
                                    window.location.href = url;
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Count',
                    data: countsource,
                    color: 'var(--purple)'
                }],
                credits: {
                    enabled: false
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });
        </script>
    </body>
</html>
