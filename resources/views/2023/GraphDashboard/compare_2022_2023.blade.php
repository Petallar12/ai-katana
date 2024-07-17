@extends('layout')
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Comparison of New Lives 2022 to 2023</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link  rel="stylesheet" href="{{ asset('css/graphdashboard.css') }}">

    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div class="container">
        <div id="container"></div>
    </div>
    <script type="text/javascript">
        var source = <?php echo json_encode($source)?>;
        var renewal_2023 = <?php echo json_encode($renewal_2023)?>;
        var cancelled_2023 = <?php echo json_encode($cancelled_2023)?>;
        var no_record_2023 = <?php echo json_encode($no_record_2023)?>;
        
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Comparison of New Lives 2022 to 2023"
            },
            xAxis: {
                categories: ['New Lives 2022', 'Renewals 2023', 'Cancelled 2023', 'No Record']
            },
            yAxis: {
                title: {
                    text: 'Number of New Lives'
                }
            },
            series: [{
                name: 'Comparison',
                data: [{
                    y: source.length > 0 ? source[0].count : 0,
                    color: '#037d50', // Green color
                    url: 'lives_2022_index' // URL for New Lives 2022
                }, {
                    y: renewal_2023.length > 0 ? renewal_2023[0].count : 0,
                    color: '#007bff', // Blue color
                    url: 'renewal_index' // URL for Renewals 2023
                }, {
                    y: cancelled_2023.length > 0 ? cancelled_2023[0].count : 0,
                    color: '#ff0000', // Red color
                    url: 'cancelled_index' // URL for Cancelled 2023
                }, {
                    y: parseInt(no_record_2023), // Using the manually set value here
                    color: 'black', // Black color for 'No Record' bar
                    url: ''
                }],
                dataLabels: {
                    enabled: true
                }
            }],
                        plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {
                                if (this.options.url) {
                                    window.open(this.options.url, '_blank');
                                }
                            }
                        }
                    }
                }
            },

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            enabled: false
                        }
                    }
                }]
            }
        });
    </script>
</body>
</html>
@endsection