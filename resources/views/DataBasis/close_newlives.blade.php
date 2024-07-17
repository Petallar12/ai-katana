@extends('layout')
@section('content')
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

    .no-menu #menu {
    display: none;
} 
 
    </style>    
     
    </head>
    <body class="no-menu"> 
        <br><br>
        
    <div class="container">
    <div class="row">
        <table class='table table-bordered'>
            <thead class="thead-light">
                <th colspan="14">Case Closed New Lives 2022</th>         
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
        $case_closed = array();
$query = "SELECT DISTINCT case_closed FROM accountsection where lives_2022='New Lives'                
                    AND start_date BETWEEN '2022-01-01' AND '2022-12-31' order by case_closed";
$query_run = mysqli_query($con, $query);
if(mysqli_num_rows($query_run) > 0) {
    while($row = mysqli_fetch_assoc($query_run)) {
        $case_closed[] = $row['case_closed'];
    }
}

        $total_counts = array_fill(1, 12, 0);
        $grand_total = 0;
        foreach ($case_closed as $case_closed) {
            $case_total = 0;
            ?>
            <tr>
            <td><?=$case_closed?></td>
            <?php 
            $query = "SELECT MONTH(start_date) as month, COUNT(case_closed) as count 
                    FROM accountsection 
                    WHERE case_closed = '$case_closed' 
                    AND lives_2022='New Lives'                
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
    @endsection