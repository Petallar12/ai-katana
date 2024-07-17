<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Datalokey') }}</title>
    
        <link rel="icon" type="image/png" href="/public/favicon.png">

        {{-- @vite(['resources/sass/app.scss',  'resources/js/app.js'])  --}} 
      
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        {{-- datatables --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
        
        {{-- DATA TABLES --}}

        {{-- ONLINE SCRIPT --}}
        {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        {{-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}

        {{-- OFFLINE SCRIPT --}}
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

        
        <style>          
        
            
        
        
            </style>

<head>
    <title>IPMI Clients</title>

    
    

        <style>
        body{
                background-image: url('/assets/images/lokeybgblur.jpg');
                background-attachment: fixed;
                background-size: cover;
                background-position: center;         
        }

        table {
            font-size: 13px;
            text-align: center;
            background-color: white;
            
        }

        th {
            font-size: 15px;
            text-align: center;
        }

        a {
            color: black;
        }

        /* .btn {
            padding-left: 10px;
        } */
 
        /* .search {
            text-align: right;
            margin-left: 10px;
            
        } */

        .containerTable {
          background-color: rgb(255, 255, 255, .5);
          width:97%;
          border-radius: 10px;
          text-align: center;
          justify-content: center;
          margin: 0 auto;
          
        }
        
        h1 {
          text-align: center;
          color: white;
        }
        /* word Search */
        .dataTables_filter {
        /* Add styles for the search input */
        font-weight: 500;
        padding: 0 20px 15px 0;
        
        }

    /* search button  */
        #table_filter input[type="search"] {
        /* Add styles for the search text box */
        font-weight: 500;
        width: 70%;
        border: none;
        border-radius: 30px;
        font-size: 15px;
        background: rgba(255,255,255, .5);
        padding: 5px 10px 5px 10px;
        outline: none;
        }
    /* button Color */
        .btnColor {
        /* Add styles for the search text box */
        width: 0 auto;
        border: none;
        border-radius: 30px;
        color: white;
        padding: 5px 10px 5px 10px;
        outline: none;
        background-color: red;
        /* background-color: rgb(10, 96, 194); */
        transition: 0.5s;
        background-size: 200% auto;
        text-align: center;
        }

        .btnColor:hover {
            background-color: rgb(65, 166, 242);
        }
     
        #table_length select {
        /* Add styles for the "Show X entries" dropdown */
        font-weight: 500;
        width: 36%;
        border: none;
        border-radius: 30px;
        font-size: 15px;
        background: rgba(255,255,255, .5);
        padding: 5px 5px 5px 5px;
        outline: none;
                
        }
        
        .dataTables_length {
        /* Add styles for the whole part of "Show X entries" */
        font-weight: 500;
        padding: 0 0 15px 20px;
        
        } 

        .dataTables_paginate {
        /* Add styles for the pagination controls */
        font-weight: 500;
        }

        .dataTables_info {
        /* Add styles for the "Showing X to Y of Z entries" text */
        font-weight: 500;
        padding: 0 0 0 20px;
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin: -20px 0 0 -20px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            
        }

        @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }

        #table tbody {
        display: none;
        }

        /* .back{
        position:fixed;
        display:flex;
        flex-direction: column;
        margin-left:-160px;
        } */

        /* .back a,  form button {  
        background: rgba(240, 223, 223, 0.4);  
        font-weight: 600;
        text-decoration:none;  
        margin-bottom:8px;
        padding:10px;  
        text-align: center;
        border-radius: 100px;
        }

        .back i{
        margin-left:0px;
        font-size:25px;
        width: 30px;
        height: 30px;

        }
        i{
        color:white;
        text-align: center;
        }
     */
  </style>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="spinner"></div>

    <div class="text">
        <h1>Premium of Clients 2023</h1>
    </div>
    <br/>

    

    <div class="containerTable">
    
        <br>

        <table id="table" class="display nowrap" style="width:100%">
            <div class="back">
                <a href="/2023/dashboard/premium_commission"><h4><b>RETURN TO GRAPH</b></a></h4>
            </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Policy</th>
                    <th>Membership ID</th>
                    <th>Full Name</th>
                    {{-- <th>Insurer</th> --}}
                    <th>Premium</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    {{-- <th>End Date</th>
                    <th>Source of Inquiry</th> --}}
                    {{-- <th>Group Name</th> --}}
                    {{-- <th>Case Officer Handling Renewal 2023</th> --}}
                    {{-- <th>Membership Certificate</th>
                    <th>Invoice</th> --}}
                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accountsection_2023 as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->policy }}</td>
                    <td>{{ $item->membership }}</td>
                    <td>{{ $item->full }}</td>
                    {{-- <td>{{ $item->insurer }}</td> --}}
                    <td><b>${{ $item->convert_premium_USD }}</b></td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->end_date }}</td>
                    {{-- <td>{{ $item->end_date }}</td>
                    <td>{{ $item->source_inquiry }}</td>                    
                    <td>{{ $item->case_officer_2023 }}</td> --}}
                    {{-- <td>@if ($item->attachment)
                        <a href="{{  asset('storage/images/' . $item->attachment) }}" class="btn btn-primary" target="_blank">View Attachment</a>
                    @else
                        No Attachment
                    @endif</td>
                    <td>@if ($item->attachment_2)
                        <a href="{{  asset('storage/attachment_2/' . $item->attachment_2) }}" class="btn btn-primary" target="_blank">View Attachment</a>
                    @else
                        No Attachment
                    @endif</td> --}}
                  

                    <td>
                        <a href="{{ url('/2023/2023datagraph/' . $item->id) }}" title="View Client"><button class="btnColor"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                        {{-- @if(auth()->user()->role == '1' || auth()->user()->role == '3' ) --}}
                            {{-- <a href="{{ url('/2023/2023datagraph/' . $item->id . '/edit') }}" title="Edit Client"><button class="btnColor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                            <form method="POST" action="{{ url('/2023/2023datagraph' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btnColor" type="submit" title="Delete Client" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            </form> --}}
                        {{-- @endif --}}
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>
    
    <br>
    <form action="{{ url('/2023/2023datagraph/index') }}" method="GET">
    </form>
</div>

 
<script>
    $(document).ready(function () {
    $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "scrollX": true,
        "info": true,
        "autoWidth": true,
        "initComplete": function(settings, json) {
            $('#table tbody').css('display', 'table-row-group'); // Show the table after the DataTable is fully loaded.
            $('.spinner').hide(); // Hide the spinner after the DataTable is fully loaded.
        }
    });
});

</script>
</body>

