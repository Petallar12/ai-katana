@extends('layout')
@section('content')
{{-- Use to set date from database to a Different Format 01-March-2024  --}}
@php
use Carbon\Carbon;
@endphp
<head>
    <link  rel="stylesheet" href="{{ asset('css/notif.css') }}">
</head>
<style>
/* Add any necessary custom styles here */
</style>
<h1 class="text-center">Due for Renewal</h1>
<p class="text-center text-white">{{ count($renewals) }} Clients due for Renewal</p>

<body>
<div class="spinner"></div>

<!-- i just hide the existing envelope for send email so i can use only the one in javascript -->
<button id="sendCsvEmail" class="btnColor"><i class="fa fa-envelope" aria-hidden="true"></i></button>
    <div class="containerTable">
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
        <!-- <select class="renewal_month" id="renewal_month" onchange="applyFilters();">
            <option value="" disabled selected>Renewal Month</option>
            <option value="">Select All</option>
            @foreach (range(1, 12) as $month)
                <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
            @endforeach
        </select> -->
        
        
        <div class="row">
        <table id='table' class='display nowrap' style="width:100%">
        <thead>
            <tr>
                <th>View</th>
                <th>Membership Number</th>
                <th>Client's Name</th>
                <th>Renewal Date</th>
                <th>Contact Number</th>
                <th>Personal Email Address</th>
                <th>Group Identifier</th>
                <th>Group Name</th>
                <th>Case Officer</th>
                <th>Renewal Handler</th>
                <th>Premium</th>
                <th>Broker's Account</th>
            </tr>
        </thead>
        <tbody>
            @foreach($renewals as $row)
            <tr>
                <td>
                    <button class="btnColor"><a href="{{ date('Y', strtotime($row->start_date)) == '2023' ? url('/2023/accountsection/' . $row->id) : url('/2024/accountsection/' . $row->id) }}" title="Show Client">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a></button>
                </td>
                <td>{{ $row->membership }}</td>
                <td>{{ $row->full }}</td>
                <td>{{ Carbon::parse($row->renewal_date)->format('d F Y') }}</td>
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

<!-- this script is for export to csv excel copy or print -->
<!-- Include jQuery and DataTables libraries -->    
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Include DataTables Buttons libraries -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function () {
    const spinner = $('.spinner');
    const table = $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "scrollX": true,
        "dom": 'Bfrtip',
        "buttons": [
            {
                extend: 'csv',
                text: '<i class="fa fa-download"></i>',
                titleAttr: 'Export to CSV',
                exportOptions: {
                    columns: ':not(:first-child)' // Exclude the first column (View)
                }
            },
            {
                text: '<i class="fa fa-envelope"></i>', // This is your custom button
                titleAttr: 'Send CSV via Email',
                className: 'btnColor',
                action: function ( e, dt, node, config ) {
                    $('#sendCsvEmail').click(); // Trigger the existing event for sending the email
                }
            }
        ],
        "initComplete": function (settings, json) {
            spinner.hide();
            $('#table tbody').css('display', 'table-row-group');
        }
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
            if (row[6]) groupIdentifiers.add(row[6]); // Check if value is not empty or null
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
        dropdown.append('<option value="">Select All</option>'); // Add Select All option
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

        var csvContent = "";
        csvContent += "Membership Number,Client's Name,Renewal Date,Contact Number,Personal Email Address,Group Identifier,Group Name,Case Officer,Renewal Handler,Premium USD,Broker's Account\n";

        filteredData.forEach(function(rowArray) {
            var rowData = rowArray.slice(1); // Skip the first column (View)
            rowData[9] = rowData[9].replace(/,/g, ''); // Remove number formatting from Premium
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

    applyFilters(); // Apply filters initially to update dropdowns based on the initial data
});
</script>


@endsection
