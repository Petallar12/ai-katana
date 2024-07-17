@extends('layout')
@section('content')

    <head>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style>
             
        table {
            font-size: 13px;
            text-align: center;
            background-color: white;
            padding-bottom: 10px;
            border-radius: 5px;
            border: none;
        }

        th {
            font-size: 15px;
        }
       
        .containerTable {
          background-color: rgb(255, 255, 255, .5);
          width: 70%;
          border-radius: 10px;
          margin: 0 auto;
          padding: 15px;
        }
        
        h1 {
          text-align: center;
          color: white;
          padding-top: 40px;
        }

        .dataTables_filter {
        /* Add styles for the search input */
        font-weight: 500;
        padding-bottom: 10px;
        }

        #myTable_filter input[type="search"] {
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
     
        #myTable_length select {
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
        } 

        .dataTables_paginate {
        /* Add styles for the pagination controls */
        font-weight: 500;
        }

        .dataTables_info {
        /* Add styles for the "Showing X to Y of Z entries" text */
        font-weight: 500;
        }
   
    </style>

    </head>

    <h1 class="text-center">IPMI Groups with 60 Years Old and Above</h1>

    <body>
        <div class="containerTable">
            <div class="row">
                <table id='myTable' class='table table-bordered display'>
                    <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Number of Clients with 60+ Years old</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $row->group_name }}</td>
                                <td>{{ $row->count }}</td>            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            });
        </script>

    @endsection