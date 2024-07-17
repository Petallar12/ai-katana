@extends('layout')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
    <style>
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

        #table thead, #table tbody {
            display: none;
        }

        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollHead table {
            margin-bottom: 0 !important;
        }

        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody table {
            border-top: none;
        }
    </style>
</head>
<body>

    <div class="header-section">
        <!-- Header -->
        <h1 class="title-header">IPMI Clients 2022</h1>
    </div>

    <div class="spinner"></div>

    <div class="container-index">
        <table id="table" class="table table-striped nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Membership ID</th>
                    <th>Full Name</th>
                    <th>Policy</th>
                    <th>Insurer</th>
                    <th>Lives</th>
                    <th>Start Date</th>
                    <th>Placement Date</th>
                    <th>Group Name</th>
                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' )
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($accountsection as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->membership }}</td>
                    <td>{{ $item->full }}</td>
                    <td>{{ $item->policy }}</td>
                    <td>{{ $item->insurer }}</td>
                    <td>{{ $item->lives_2022 }}</td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->placement_date }}</td>
                    <td>{{ $item->group_name }}</td>
                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' )
                    <td>
                        <a href="{{ url('/accountsection/' . $item->id) }}" title="View Client"><button class="actionBtn"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                        @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' )
                            <a href="{{ url('/accountsection/' . $item->id . '/edit') }}" title="Edit Client"><button class="actionBtn"><i class="fa fa-solid fa-square-pen" aria-hidden="true"></i></button></a>
                            <form method="POST" action="{{ url('/accountsection' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="actionBtn delete-btn" type="submit" title="Delete Client" onclick="return confirm('Confirm delete?')"><i class="fa-solid fa-circle-minus"></i></button>
                            </form>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            const spinner = $('.spinner');
            const tableHeader = $('#table thead');
            const tableBody = $('#table tbody');

            const table = $('#table').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                scrollX: true,
                info: true,
                autoWidth: true,
                fixedHeader: {
                    header: true,
                },
                initComplete: function (settings, json) {
                    tableHeader.css('display', 'table-header-group'); 
                    tableBody.css('display', 'table-row-group'); 
                    spinner.hide(); 
                    table.columns.adjust().draw(); 
                }
            });

            function reloadTable() {
                table.ajax.reload();
            }
        });
    </script>
</body>
</html>
@endsection
