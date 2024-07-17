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
                height: 600px;
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
            var data = <?php echo json_encode($data)?>;

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Premium per Country'
                },
                xAxis: {
                    categories: data.map(function(item) { return item.name; }),
                    labels: {
                        useHTML: true,
                        rotation: -90, // Rotate labels for better fit
                        align: 'right', // Align labels to the right
                        formatter: function() {
                            return '<a href="/2024/dashboard_index/country_premium_index?country_residence=' + encodeURIComponent(this.value) + '">' + this.value + '</a>';
                        },
                        style: {
                            textAlign: 'center',
                            whiteSpace: 'nowrap'
                        }
                    }
                },
                yAxis: [{
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function() {
                            return '$' + Highcharts.numberFormat(this.value, 0, '.', ',');
                        }
                    }
                }],
                tooltip: {
                    shared: true,
                    formatter: function() {
                        return '<b>' + this.x + '</b><br/>Premium: $' + Highcharts.numberFormat(this.y, 2, '.', ',');
                    }
                },
                plotOptions: {
                    column: {
                        color: 'var(--purple)',
                        dataLabels: {
                            enabled: true,
                            inside: false,
                            formatter: function() {
                                return this.y > 0 ? '$' + Highcharts.numberFormat(this.y, 2, '.', ',') : null;
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
                                    var url = '/2024/dashboard_index/country_premium_index?country_residence=' + encodeURIComponent(this.category);
                                    window.location.href = url;
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Total Premium',
                    data: data.map(function(item) { return item.premium_sum; }),
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
