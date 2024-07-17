@extends('layout')
@section('content')
{{-- Use to set date from database to a Different Format 01-March-2024  --}}
@php
use Carbon\Carbon;
@endphp
<head>
    <link rel="stylesheet" href="{{ asset('css/renewals.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
</head>

<div class="header-section">
<h1 class="title-header">Due for Renewal</h1>
</div>

<body>
<div class="spinner"></div>

<div class="container-index">

    <div class="table-filters">
            <select class="group_identifier" id="group_identifier" onchange="applyFilters();">
                <option value="" disabled selected>Group Identifier</option>
                <option value="">Select All</option>
                @foreach ($Group_Identifierfilter as $identifier)
                <option value="{{ $identifier }}">{{ $identifier }}</option>
                @endforeach
            </select>
            <select class="group_name" id="group_name" onchange="applyFilters();">
                <option value="" disabled selected>Group Name</option>
                <option value="">Select All</option>
                @foreach ($Group_Namefilter as $group_name)
                <option value="{{ $group_name }}">{{ $group_name }}</option>
                @endforeach
            </select>
            <select class="case_officer" id="case_officer" onchange="applyFilters();">
                <option value="" disabled selected>Case Officer</option>
                <option value="">Select All</option>
                @foreach ($Case_Officerfilter as $case_officer)
                <option value="{{ $case_officer }}">{{ $case_officer }}</option>
                @endforeach
            </select>
            <select class="renewal_handler" id="renewal_handler" onchange="applyFilters();">
                <option value="" disabled selected>Renewal Handler</option>
                <option value="">Select All</option>
                @foreach ($Case_Officerfilter as $case_officer)
                <option value="{{ $case_officer }}">{{ $case_officer }}</option>
                @endforeach
            </select>
            <select class="renewal_month" id="renewal_month" onchange="applyFilters();">
                <option value="" disabled selected>Renewal Month</option>
                <option value="">Select All</option>
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                @endforeach
            </select>
        </div>

    <div class="row">
        <table id="table" class="table table-striped nowrap" style="width: 100%">
            <thead>
                <tr>
                    <th>View</th>
                    <th>Membership ID</th>
                    <th>Client's Name</th>
                    <th>Renewal Date</th>
                    <th>Contact Number</th>
                    <th>Personal Email Address</th>
                    <th>Group Identifier</th>
                    <th>Group Name</th>
                    <th>Case Officer</th>
                    <th>Renewal Handler</th>
                    <th>Premium</th>
                    <th>Broker Account</th>
                </tr>
            </thead>   
            <tbody>
                @foreach($renewals as $row)
                <tr>
                    <td>
                        <a href="{{ date('Y', strtotime($row->start_date)) == '2023' ? url('/2023/accountsection/' . $row->id) : url('/2024/accountsection/' . $row->id) }}" title="Show Client"><button class="actionBtn">
                        <i class="fa-solid fa-square-up-right"></i>
                        </button></a>
                    </td>
                    <td>{{ $row->membership }}</td>
                    <td>{{ $row->full }}</td>
                    <td>{{ Carbon::parse($row->renewal_date)->format('m-d-Y') }}</td>
                    <td>{{ $row->contact_number }}</td>
                    <td>{{ $row->applicant_email_address }}</td>
                    <td>{{ $row->group_identifier }}</td>
                    <td>{{ $row->group_name }}</td>
                    <td>{{ $row->case_officer }}</td>
                    <td>{{ $row->case_officer_renewals }}</td>
                    <td>{{ number_format($row->convert_premium_USD) }}</td>
                    <td>{{ $row->account }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="export">
    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')
    <a href="#" class="export-btn">
        <i class="fa fa-cloud-download" aria-hidden="true"></i> EXPORT
    </a>
    @endif
</div>

<script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function () {
    const spinner = $('.spinner');
    const tableFilters = $('.table-filters');
    tableFilters.hide(); // Hide the table filters initially

    const table = $('#table').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        scrollX: true,
        ordering: true,
        order: [[3, 'asc']],
        lengthMenu: [
                    [15, 30, 50, 100],
                    ['15', '30', '50', '100']
                ],
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fa fa-download"></i>',
                titleAttr: 'Export to CSV',
                exportOptions: {
                    columns: ':not(:first-child)' // Exclude the first column (View)
                },
                className: 'd-none' // Hide the default button
            }
        ],
        initComplete: function (settings, json) {
            spinner.hide();
            $('#table tbody').css('display', 'table-row-group');
            tableFilters.show(); // Show the table filters once loading is complete
        }
    });

    // Link custom export button to DataTable export action
    $('.export-btn').on('click', function () {
        table.button('.buttons-csv').trigger();
    });

    function capitalizeFirstLetter(string) {
        return string.replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
    }

    function updateDropdowns(filteredData) {
        const groupIdentifiers = new Set();
        const groupNames = new Set();
        const caseOfficers = new Set();
        const renewalHandlers = new Set();

        filteredData.forEach(row => {
            if (row[6]) groupIdentifiers.add(row[6]);
            if (row[7]) groupNames.add(row[7]);
            if (row[8]) caseOfficers.add(row[8]);
            if (row[9]) renewalHandlers.add(row[9]);
        });

        updateDropdownOptions('#group_identifier', groupIdentifiers);
        updateDropdownOptions('#group_name', groupNames);
        updateDropdownOptions('#case_officer', caseOfficers);
        updateDropdownOptions('#renewal_handler', renewalHandlers);
    }

    function updateDropdownOptions(selector, options) {
        const dropdown = $(selector);
        const currentValue = dropdown.val();
        dropdown.empty();
        dropdown.append(`<option value="" disabled>${capitalizeFirstLetter(dropdown.attr('id').replace('_', ' '))}</option>`);
        dropdown.append('<option value="">Select All</option>');
        options.forEach(option => {
            dropdown.append(`<option value="${option}">${option}</option>`);
        });
        dropdown.val(currentValue);
    }

    function applyFilters() {
        table.draw();
        const filteredData = table.rows({ filter: 'applied' }).data().toArray();
        updateDropdowns(filteredData);
    }

    $('#sendCsvEmail').on('click', function () {
        var filteredData = table.rows({ filter: 'applied' }).data().toArray();
        var csvContent = "Membership Number,Client's Name,Renewal Date,Contact Number,Personal Email Address,Group Identifier,Group Name,Case Officer,Renewal Handler,Premium USD,Broker's Account\n";

        filteredData.forEach(function(rowArray) {
            var rowData = rowArray.slice(1);
            rowData[9] = rowData[9].replace(/,/g, '');
            var row = rowData.join(",");
            csvContent += row + "\n";
        });
        sendCsvDataToServer(csvContent);
    });

    function sendCsvDataToServer(csvContent) {
        var encodedUri = encodeURI(csvContent);

        $.ajax({
            url: '/2023/notification/send-csv-email',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                csvData: encodedUri
            },
            success: function(response) {
                alert('Email sent successfully!');
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    }

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var groupIdentifier = $('.group_identifier').val();
            var groupName = $('.group_name').val();
            var caseOfficer = $('.case_officer').val();
            var renewalHandler = $('.renewal_handler').val();
            var renewalMonth = $('.renewal_month').val();

            var matchGroupIdentifier = groupIdentifier ? data[6] === groupIdentifier : true;
            var matchGroupName = groupName ? data[7] === groupName : true;
            var matchCaseOfficer = caseOfficer ? data[8] === caseOfficer : true;
            var matchRenewalHandler = renewalHandler ? data[9] === renewalHandler : true;
            var matchRenewalMonth = renewalMonth ? new Date(data[3]).getMonth() + 1 == renewalMonth : true;

            return matchGroupIdentifier && matchGroupName && matchCaseOfficer && matchRenewalHandler && matchRenewalMonth;
        }
    );

    $('.group_identifier, .group_name, .case_officer, .renewal_handler, .renewal_month').change(function () {
        applyFilters();
    });

    applyFilters();
});

</script>

@endsection
