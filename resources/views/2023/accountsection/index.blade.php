@extends('layout')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
</head>
<body>

    <div class="header-section">
        <!-- Header -->
        <h1 class="title-header">IPMI Clients 2023</h1>
    </div>

    <div class="container-index">
        <table id="table" class="table table-striped nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>MEMBERSHIP ID</th>
                    <th>FULL NAME</th>
                    <th>
                        <select class="policy_filter" onchange="reloadTable();">
                            <option value="">Policy</option>
                            @foreach ($Policyfilter as $policy)
                            <option value="{{ $policy }}">{{ $policy }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="insurer_filter" onchange="reloadTable();">
                            <option value="">Insurer</option>
                            @foreach ($Insurerfilter as $insurer)
                            <option value="{{ $insurer }}">{{ $insurer }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="source_inquiry" onchange="reloadTable();">
                            <option value="">Source of Inquiry</option>
                            @foreach ($sourceInquiries as $inquiry)
                            <option value="{{ $inquiry }}">{{ $inquiry }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="lives_2023_filter" onchange="reloadTable();">
                            <option value="">Lives</option>
                            @foreach ($Lives_2023_filter as $lives_2023)
                            <option value="{{ $lives_2023 }}">{{ $lives_2023 }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>
                        <select class="group_name" onchange="reloadTable();">
                            <option value="">Group Name</option>
                            @foreach ($Group_name_filter as $group_name)
                            <option value="{{ $group_name }}">{{ $group_name }}</option>
                            @endforeach
                        </select>
                    </th>
                    <th>PLACEMENT DATE</th>
                    <th>CASE CLOSED BY</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- Extract Button -->
            <div class="export">
                @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')
                <a href="{{ route('export.csv') }}" class="export-btn">
                    <i class="fa fa-cloud-download" aria-hidden="true"></i> EXPORT
                </a>
                @endif
            </div>
    </div>

    

    <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var userRole = @json(auth()->user()->role);

            const table = $('#table').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                order: [[0, 'asc']],
                scrollX: true,
                info: true,
                autoWidth: false,
                fixedHeader: true,
                lengthMenu: [
                    [15, 30, 50, 100],
                    ['15', '30', '50', '100']
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('index') }}",
                    type: "GET",
                    data: function (d) {
                        d.source_inquiry = $('.source_inquiry').val();
                        d.policy = $('.policy_filter').val();
                        d.insurer = $('.insurer_filter').val();
                        d.lives_2023 = $('.lives_2023_filter').val();
                        d.group_name = $('.group_name').val();
                        d.group_identifier = $('.group_identifier').val();
                    },
                    dataSrc: function (json) {
                        updateFilterOptions(json.filters);
                        return json.data;
                    }
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'membership', name: 'membership', orderable: false },
                    { data: 'full', name: 'full', orderable: false },
                    { data: 'policy', name: 'policy', orderable: false },
                    { data: 'insurer', name: 'insurer', orderable: false },
                    { data: 'source_inquiry', name: 'source_inquiry', orderable: false },
                    { data: 'lives_2023', name: 'lives_2023', orderable: false },
                    { data: 'group_name', name: 'group_name', orderable: false },
                    { data: 'placement_date', name: 'placement_date', orderable: false },
                    { data: 'case_closed', name: 'case_closed', orderable: false },
                    {
                        data: null,
                        render: function (data, type, row) {
                            var actions = '<a href="' + "{{ url('/2023/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="actionBtn"><i class="fa fa-eye"></i></button></a>';
                            if (userRole === 'IT admin' || userRole === 'Encoder') { // Allow both roles 1 and 2
                                actions += '<a href="' + "{{ url('/2023/accountsection/') }}/" + row.id + '/edit" title="Edit Client"><button class="actionBtn"><i class="fa-solid fa-square-pen"></i></button></a>' +
                                           '<button class="actionBtn delete-btn" data-id="' + row.id + '" title="Delete Client"><i class="fa-solid fa-circle-minus"></i></button>' +
                                           '<button class="actionBtn transfer-btn" data-id="' + row.id + '" title="Transfer Data"><i class="fa fa-exchange"></i></button>';
                            }
                            return actions;
                        }
                    }
                ]
            });

            function updateDropdownOptions(selector, options, defaultLabel) {
                const dropdown = $(selector);
                const currentValue = dropdown.val();
                dropdown.empty();
                dropdown.append(`<option value="">${defaultLabel}</option>`);
                if (options) {
                    options.forEach(option => {
                        dropdown.append(`<option value="${option}">${option}</option>`);
                    });
                }
                dropdown.val(currentValue);
            }

            function updateFilterOptions(filters) {
                if (filters) {
                    updateDropdownOptions('.policy_filter', filters.policies, 'Policy');
                    updateDropdownOptions('.insurer_filter', filters.insurers, 'Insurer');
                    updateDropdownOptions('.source_inquiry', filters.source_inquiries, 'Source');
                    updateDropdownOptions('.lives_2023_filter', filters.lives_2023, 'Lives');
                    updateDropdownOptions('.group_name', filters.group_names, 'Group Name');
                    updateDropdownOptions('.group_identifier', filters.group_identifiers, 'Group Identifier');
                }
            }

            function reloadTable() {
                table.ajax.reload();
            }

            // Deletion
            $('#table').on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                confirmDelete(id);
            });

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteRow(id);
                    }
                });
            }

            function deleteRow(id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/2023/accountsection/delete') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        Swal.fire(
                            'Deleted!',
                            'The client has been deleted.',
                            'success'
                        );
                        table.ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the client.',
                            'error'
                        );
                        console.log('Error:', data);
                    }
                });
            }

            // Transfer
            $(document).on('click', '.transfer-btn', function () {
                var id = $(this).data('id');
                transferData(id);
            });

            function transferData(id) {
                $.ajax({
                    url: '/2023/accountsection/' + id + '/transfer',
                    method: 'POST',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function (response) {
                        alert('Data transferred successfully!');
                        table.ajax.reload();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log('Error transferring data:', xhr.responseText);
                        alert('Error transferring data. Check the console for details.');
                    }
                });
            }

            function updateExportCsvUrl() {
                var filters = {
                    source_inquiry: $('.source_inquiry').val(),
                    policy: $('.policy_filter').val(),
                    insurer: $('.insurer_filter').val(),
                    lives_2023: $('.lives_2023_filter').val(),
                    group_name: $('.group_name').val(),
                    group_identifier: $('.group_identifier').val()
                };

                var queryString = $.param(filters);
                var newExportCsvUrl = "{{ route('export.csv') }}" + "?" + queryString;
                $("a.export-btn").attr("href", newExportCsvUrl);
            }

            $('.source_inquiry, .policy_filter, .insurer_filter, .lives_2023_filter, .group_name, .group_identifier').on('change', function () {
                updateExportCsvUrl();
                reloadTable();
            });

            updateExportCsvUrl();
        });
    </script>
</body>
</html>
@endsection

