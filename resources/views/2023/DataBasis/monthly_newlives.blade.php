<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Lives Closed</title>

    <style>
        :root {
            --white: #ffffff;
            --snow: #fafafa;
            --font-dark: #3b3b3b;
            --purple: #5046e5;
            --dark-purple: #392fc2;
            --light-purple: #cbc9f7;
        }

        * {
            font-family: 'Poppins', sans-serif;
            padding: 0;
            margin: 0;
            color: var(--font-dark);
        }

        .table-container {
            padding: 5px 5px 0;
        }

        .card {
            overflow: hidden;
            border-radius: 4px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: var(--purple);
            color: var(--white);
            text-transform: uppercase;
            font-size: 12px;
            cursor: pointer;
            position: relative;
            font-weight: 400;
        }

        .table-row-label th::after {
            content: '\25B2'; /* Default sorting icon */
            position: absolute;
            right: 10px;
            font-size: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: normal;
        }

        .table-row-label th.sorted-asc::after {
            content: '\25B2'; /* Up arrow for ascending sort */
        }

        .table-row-label th.sorted-desc::after {
            content: '\25BC'; /* Down arrow for descending sort */
        }

        .table td {
            font-size: 12px;
        }

        .table th[colspan="14"] {
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }

        .total-row td {
            background-color: var(--purple);
            color: var(--white);
            font-weight: bold;
        }

        .case-officer {
            font-weight: bold;
            border-right: solid 3px white;
        }

        .case-officer:hover {
            background-color: var(--dark-purple);
            color: var(--white);
            transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table tbody tr:nth-child(odd) {
            background-color: var(--snow);
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--light-purple);
        }
    </style>

    <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#myTable10').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "order": []
            });

            $('th').on('click', function () {
                var table = $('#myTable10').DataTable();
                var header = $(this);
                var columnIndex = header.index();

                header.toggleClass('sorted-asc sorted-desc');

                if (header.hasClass('sorted-asc')) {
                    table.order([columnIndex, 'asc']).draw();
                } else if (header.hasClass('sorted-desc')) {
                    table.order([columnIndex, 'desc']).draw();
                } else {
                    table.order([]).draw(); // Remove sorting
                }
            });
        });
    </script>
</head>

<body>
    <div class="table-container">
        <div class="card">
            <table id='myTable10' class="table">
                <thead>
                    <tr>
                        <th colspan="14">Case Closed Count - New Lives</th>
                    </tr>
                    <tr class="table-row-label">
                        <th>Case Officer</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $case_closed = array();
                    $query = "SELECT DISTINCT case_closed FROM accountsection_2023 
                              WHERE (lives_2023 = 'New Lives' OR lives_2023 = 'New Lives and Existing') 
                              AND insurance_type ='IPMI' 
                              AND (policy = 'Active' OR policy = 'Pended')     
                              AND (status = 'Complete' OR status = 'Incomplete')
                              AND placement_date BETWEEN '2023-01-01' AND '2023-12-31' 
                              ORDER BY case_closed";

                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            $case_closed[] = $row['case_closed'];
                        }
                    }

                    $total_counts = array_fill(1, 12, 0);
                    $grand_total = 0;
                    foreach ($case_closed as $case) {
                        $case_total = 0;
                    ?>
                        <tr>
                            <td class="case-officer"><?= $case ?></td>
                            <?php
                            $query = "SELECT MONTH(placement_date) as month, COUNT(case_closed) as count 
                                      FROM accountsection_2023
                                      WHERE case_closed = '$case' 
                                      AND (lives_2023='New Lives' OR lives_2023='New Lives and Existing')        
                                      AND insurance_type ='IPMI' 
                                      AND (policy = 'Active' OR policy = 'Pended' OR policy = 'Lapsed')
                                      AND (status = 'Complete' OR status = 'Incomplete')
                                      AND placement_date BETWEEN '2023-01-01' AND '2023-12-31' 
                                      GROUP BY MONTH(placement_date)";

                            $query_run = mysqli_query($con, $query);
                            $counts = array_fill(1, 12, 0);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                                    $counts[$row['month']] = $row['count'];
                                    $total_counts[$row['month']] += $row['count'];
                                    $case_total += $row['count'];
                                }
                            }
                            $grand_total += $case_total;
                           
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<td>{$counts[$i]}</td>";
                            }
                             echo "<td>{$case_total}</td>";
                            ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td>GRAND TOTAL</td>
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            echo "<td>{$total_counts[$i]}</td>";
                        }
                        ?>
                        <td><?= $grand_total ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
