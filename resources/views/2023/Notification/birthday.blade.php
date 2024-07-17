@extends('layout')
@section('content')
@php
use Carbon\Carbon;
@endphp
<head>
    <link rel="stylesheet" href="{{ asset('css/bday_notif.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<h1 class="title-header">Upcoming Birthdays</h1>
<p class="title-info">{{ $count }} Birthday Celebrants This Month</p>

<body>
<div class="spinner"></div>

<div class="container-index">
    <div class="row">
        <table id='table' class='table table-striped nowrap' style="width:100%">
            <thead>
                <tr>
                    <th>Membership No.</th>
                    <th>Client's Name</th>
                    <th>Birthday</th>
                    <th>Age</th>
                    <th>Personal Email Address</th>
                    <th>
                        {{-- Dropdown for Accounts --}}
                        <select onchange="filterAccount(this.value)">
                            <option value="" disabled selected>Broker's Account</option>
                            @foreach ($Accountfilter as $accountfilter)
                                <option value="{{ $accountfilter }}">{{ $accountfilter }}</option>
                            @endforeach
                            <option value="">All Account</option> <!-- Placeholder option to allow users to clear the filter -->
                        </select>
                    </th>
                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')
                    <th>Send Greetings</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($birthdays as $birthday)
                    <tr>
                        <td>{{ $birthday->membership }}</td>
                        <td>{{ $birthday->full }}</td>
                        <td>{{ Carbon::parse($birthday->birthday)->format('d F Y') }}</td>
                        <td>{{ $birthday->age }}</td>
                        <td>{{ $birthday->applicant_email_address }}</td>
                        <td>{{ $birthday->account }}</td>
                        @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')
                        <td>
                            <button class="actionBtn" onclick="confirmSendEmail('{{ $birthday->applicant_email_address }}', '{{ $birthday->full }}', '{{ $birthday->account }}')">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </button>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="export">
@if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder' || auth()->user()->role == 'Management')
    <a href="{{ route('export_2024.csv') }}" class="export-btn">
        <i class="fa fa-cloud-download" aria-hidden="true"></i> EXPORT
    </a>
    @endif
</div>

<script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    const spinner = $('.spinner');
    const tableBody = $('#table tbody');

    // Initially, hide the table data
    tableBody.css('display', 'none');

    const table = $('#table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "scrollX": true,
        "info": true,
        "autoWidth": false,
        "fixedHeader": true,
        "initComplete": function (settings, json) {
            tableBody.css('display', 'table-row-group'); // Show the table after the DataTable is fully loaded.
            spinner.hide(); // Hide the spinner after the DataTable is fully loaded.

            // Adjust column widths after table initialization
            table.columns.adjust();
        },
        dom: 'Bfrtip', // Include buttons for copying, exporting to CSV, Excel, and printing
        "buttons": [
            {
                extend: 'csv',
                text: '<i class="fa fa-download"></i>',
                titleAttr: 'Export to CSV',
                exportOptions: {
                    columns: ':not(:first-child)' // Excludes the first column (index 0)
                },
                className: 'd-none' // Hide the default button
            }
        ],
    });

    // Link custom export button to DataTable export action
    $('.export-btn').on('click', function () {
        $('#table').DataTable().button('.buttons-csv').trigger();
    });
});

function confirmSendEmail(emailAddress, recipientName, account) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to send a birthday greeting to ${recipientName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send it!'
    }).then((result) => {
        if (result.isConfirmed) {
            sendEmail(emailAddress, recipientName, account);
        }
    });
}

function sendEmail(emailAddress, recipientName, account) {
    let url;
    
    // Determine the correct URL based on the account
    switch(account) {
        case 'Jusmedical Sdn Bhd':
        case 'Medishure Global':
        case 'Juscall Insurane Agency Inc':
        case 'Juscall International Inc':        
            url = '/2023/notification/send-birthday-email';
            break;
        case 'Rig Associates Pte Ltd':
            url = '/2023/notification/send-birthday-rig-email';
            break;
        case 'Bricon Associates Pte Ltd':
        case 'Bricon Associates':
            url = '/2023/notification/send-birthday-bricon-email';
            break;
        case 'Luke Medical Pte Ltd':
            url = '/2023/notification/send-birthday-lukemed-email';
            break;
        case 'Juscall Insurance Agency Inc':
            url = '/2023/notification/send-birthday-juscall-email';
            break;
        case 'PT Luke Medikal Internasional':
            url = '/2023/notification/send-birthday-lukemedikal-email';
            break;
        case 'Luke International Consultant Company Ltd':
            url = '/2023/notification/send-birthday-lukeinternational-email';
            break;
        default:
            // If the account doesn't match any case, log a message and return to prevent sending an email
            console.log('No email will be sent for the account:', account);
            return; // Stop the function execution
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            email: emailAddress,
            name: recipientName,
            _token: '{{ csrf_token() }}' // Ensure you're passing CSRF token correctly
        },
        success: function(response) {
            Swal.fire({
                title: "Email Sent",
                text: `Birthday greeting has been sent to ${recipientName}.`,
                icon: "success"
            });
        },
        error: function(error) {
            console.log(error);
            Swal.fire({
                title: "Error",
                text: "Failed to send the email.",
                icon: "error"
            });
        }
    });
}

function filterAccount(account) {
    if (account) {
        // If an account is selected, append it as a query parameter
        window.location.href = '/2023/notification/birthday?account=' + account;
    } else {
        // If "All Account" is selected (account is an empty string), redirect without query parameters
        window.location.href = '/2023/notification/birthday';
    }
}
</script>
@endsection
