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
                cursor: pointer;
            }

            .sum:hover {
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
        <div id="container"></div>

        <div class="container">
            <div>
                <ul>
                    <li
                        class="sum"
                        onclick="redirectTo('newlives_2023_index')"
                        id="totalNewLives"
                    ></li>
                    <li class="text-label">Total New Lives</li>
                </ul>
            </div>
            <div>
                <ul>
                    <li
                        class="sum"
                        onclick="redirectTo('existing_2023_index')"
                        id="totalRenewals"
                    ></li>
                    <li class="text-label">Total Renewals</li>
                </ul>
            </div>
        </div>

        <script src="{{ asset('js/highcharts.js') }}"></script>
        <script type="text/javascript">
            function redirectTo(page) {
                window.location.href = `/2023/dashboard_index/${page}`;
            }

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            var totalNewLives = {{ $total_newlives[0] }};
            var totalRenewals = {{ $total_existing[0] }};

            document.getElementById('totalNewLives').innerText = formatNumber(totalNewLives);
            document.getElementById('totalRenewals').innerText = formatNumber(totalRenewals);

            var userData = <?php echo json_encode($userData) ?>;
            var userData1 = <?php echo json_encode($userData1) ?>;
            var userDataAccumulative = <?php echo json_encode($userDataAccumulative) ?>;
            var userDataAccumulative1 = <?php echo json_encode($userDataAccumulative1) ?>;

            Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monthly Count of New Lives and Renewals'
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
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    var url = '';
                                    if (this.series.name === 'New Lives') {
                                        url = '/2023/dashboard_index/newlives_2023_index?placement_date=' + encodeURIComponent(this.category);
                                    } else if (this.series.name === 'Renewals') {
                                        url = '/2023/dashboard_index/existing_2023_index?start_date=' + encodeURIComponent(this.category);
                                    }
                                    if (url) {
                                        window.location.href = url;
                                    }
                                }
                            }
                        },
                        marker: {
                            enabled: true,
                            radius: 6,
                            lineWidth: 1,
                            lineColor: '#fff',
                            symbol: 'circle'
                        }
                    }
                },
                xAxis: {
                    categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                series: [{
                    name: 'New Lives',
                    data: userDataAccumulative,
                    color: 'var(--purple)'
                }, {
                    name: 'Renewals',
                    data: userDataAccumulative1,
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
