@extends('layout')
@section('content')

@if(auth()->user()->role == '1' || auth()->user()->role == '3' )




     <style>    
        th,td{         
            text-align:center;
            font-size:15px;
            border: 1px solid #dddddd;    
            background-color:lightgray;        
        }         
        .head{
            background-color:red;
        }
        .thead-light{
            background-color:lightgray;
        }
        td:nth-child(n+14) {
            background-color: #efe9e9;
        }
        .total-row td{
            background-color: #efe9e9;
    }
 
    </style>    
     
    </head>
    <body>
        <br><br>
    <div class="container">
    <div class="row">
        <table class='table table-bordered'>
            <thead class="thead-light">
                <th colspan="14">Case Closed Renewals 2022</th>         
            <tr>
                <th>Case Officer</th>
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
                <th>Total</th>
            </tr>
        </thead class="thead-light">
        <?php 
        $con = mysqli_connect("localhost","root","","medicare_data");
        $case_officer = array();
$query = "SELECT DISTINCT case_officer FROM accountsection where lives_2022='Existing'                
                    AND start_date BETWEEN '2022-01-01' AND '2022-12-31' order by case_officer";
$query_run = mysqli_query($con, $query);
if(mysqli_num_rows($query_run) > 0) {
    while($row = mysqli_fetch_assoc($query_run)) {
        $case_officer[] = $row['case_officer'];
    }
}
        $total_counts = array_fill(1, 12, 0);
        $grand_total = 0;
        foreach ($case_officer as $case_officer) {
            $case_total = 0;
            ?>
            <tr>
            <td><?=$case_officer?></td>
            <?php 
            $query = "SELECT MONTH(start_date) as month, COUNT(case_officer) as count 
                    FROM accountsection 
                    WHERE case_officer = '$case_officer' 
                    AND lives_2022='Existing'                
                    AND start_date BETWEEN '2022-01-01' AND '2022-12-31' 
                    GROUP BY MONTH(start_date)";
            $query_run = mysqli_query($con, $query);
            $counts = array_fill(1, 12, 0);
            if(mysqli_num_rows($query_run) > 0) {
                foreach($query_run as $row) {
                    $counts[$row['month']] = $row['count'];
                    $total_counts[$row['month']] += $row['count'];
                    $case_total += $row['count'];
                }
            }
            for ($i = 1; $i <= 12; $i++) {
                echo "<td>{$counts[$i]}</td>";
            }
            ?>
            <td><?=$case_total?></td>
            </tr>
        <?php } ?>
        <tr class="total-row">
            <td>Total</td>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $grand_total += $total_counts[$i];
                echo "<td>{$total_counts[$i]}</td>";
}
?>
<td><?=$grand_total?></td>
</tr>
</table>
   </div>    

    </html>
@endif
    @endsection