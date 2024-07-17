<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

            a {
                text-decoration: none;
            }

            #chart {
                padding: 20px 20px 0;
                height: 400px;
            }

            li {
                list-style: none;
            }

            .container {
                display: flex;
                justify-content: center;
                text-align: center;
                gap: 100px;
                padding: 5px 0;
            }

            .sum {
                font-size: 20px;
                font-weight: 700;
            }

            .sum a:hover {
                color: var(--purple);
                transition: color 250ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            .text-label {
                text-transform: uppercase;
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div id="chart"></div>

        <div class="container">
            <div>
                <ul>
                    <li class="sum">
                        <a href="#">${{ $formattedsum }}</a>
                    </li>
                    <li class="text-label">Total Premium in USD</li>
                </ul>
            </div>

            <div>
                <ul>
                    <li class="sum">
                        <a href="#">${{ $formattedsum2 }}</a>
                    </li>
                    <li class="text-label">Total Commission in USD</li>
                </ul>
            </div>
        </div>

        <script src="{{ asset('js/highcharts.js') }}"></script>
        <script type="text/javascript">
            const commissionsAccumulative = <?php echo json_encode($commissionsAccumulative) ?>;
            const premiumAccumulative = <?php echo json_encode($premiumAccumulative) ?>;
            const monthsAbbreviated = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

            Highcharts.chart('chart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monthly Total of Premium and Commission'
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'top',
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                return Highcharts.numberFormat(this.y, 0, ',', ',');
                            }
                        },
                        enableMouseTracking: true,
                        lineWidth: 6
                    },
                    series: {
                        marker: {
                            enabled: true,
                            radius: 6,
                            lineWidth: 1,
                            lineColor: '#fff',
                            symbol: 'circle'
                        }
                    }
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: monthsAbbreviated
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                series: [{
                    name: 'Premium',
                    data: premiumAccumulative,
                    color: 'var(--purple)'
                }, {
                    name: 'Commissions',
                    data: commissionsAccumulative,
                    color: '#36A1FF'
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom',
                            }
                        }
                    }]
                }
            });
        </script>
    </body>
</html>
