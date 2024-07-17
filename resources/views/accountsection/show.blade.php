@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">

<div class="table-wrapper">
    <div class="button">

        <!-- Back Button -->
        <a href="javascript:history.back()" title="Go Back"><i class="fa-solid fa-circle-arrow-left"></i></a>

        @if(auth()->user()->role == '1' || auth()->user()->role == '2')
        <!-- Edit Button -->
        <a href="{{ url('/accountsection/' . $accountsection->id . '/edit') }}" title="Edit Client"><i class="fa-solid fa-square-pen"></i></a>

        <!-- Delete Button -->
        <a href="#" class="delete-link" data-id="{{ $accountsection->id }}" title="Delete Client"><i class="fa-solid fa-circle-minus"></i></a>
        
        <form id="delete-form-{{ $accountsection->id }}" method="POST" action="{{ url('/accountsection/' . $accountsection->id) }}" accept-charset="UTF-8" style="display:none">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
        </form>
        @endif
    </div>

    <div class="card-x">
        <p class="card-x-header">Client:</p><h2>{{ $accountsection->full }}</h2>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="true">Personal<br>Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="insurance-tab" data-bs-toggle="tab" href="#insurance" role="tab" aria-controls="insurance" aria-selected="false">Insurance<br>Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="renewal-tab" data-bs-toggle="tab" href="#renewal" role="tab" aria-controls="renewal" aria-selected="false">Renewal<br>Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="placement-tab" data-bs-toggle="tab" href="#placement" role="tab" aria-controls="placement" aria-selected="false">Placement<br>Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="source-tab" data-bs-toggle="tab" href="#source" role="tab" aria-controls="source" aria-selected="false">Source<br>Information</a>
            </li>
            @if(auth()->user()->role == '1' || auth()->user()->role == '2')
            <li class="nav-item">
                <a class="nav-link" id="claims-tab" data-bs-toggle="tab" href="#claims" role="tab" aria-controls="claims" aria-selected="false">View<br>Claims</a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" id="others-tab" data-bs-toggle="tab" href="#others" role="tab" aria-controls="others" aria-selected="false">Other<br>Information</a>
            </li>
        </ul>
    </div>

    <!-- Tab content -->
    <div class="tab-content">
        <div id="personal" class="tab-pane fade show active" role="tabpanel" aria-labelledby="personal-tab">
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Client Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Membership Number</th>
                        <td>{{$accountsection->membership}}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{$accountsection->title}}</td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td>{{$accountsection->full}}</td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>{{$accountsection->first}}</td>
                    </tr>
                    <tr>
                        <th>Family Name</th>
                        <td>{{$accountsection->family}}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{$accountsection->gender}}</td>
                    </tr>
                    <tr>
                        <th>Birthday</th>
                        <td>{{$accountsection->birthday}}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td>
                            <?php
                            $birthday = new DateTime($accountsection->birthday);
                            $today = new DateTime();
                            $age = date_diff($birthday, $today)->y;
                            ?>
                            {{$age}}
                        </td>
                    </tr>
                    <tr>
                        <th>Country of Nationality</th>
                        <td>{{$accountsection->country_nationality}}</td>
                    </tr>
                    <tr>
                        <th>Country of Residence</th>
                        <td>{{$accountsection->country_residence}}</td>
                    </tr>
                    <tr>
                        <th>Residence Address</th>
                        <td>{{$accountsection->residence}}</td>
                    </tr>
                    <tr>
                        <th>Mailing Address</th>
                        <td>{{$accountsection->mailing_address}}</td>
                    </tr>
                    <tr>
                        <th>Primary Contact Number</th>
                        <td>{{$accountsection->contact_number}}</td>
                    </tr>
                    <tr>
                        <th>Secondary Contact Number</th>
                        <td>{{$accountsection->secondary_contact_number}}</td>
                    </tr>
                    <tr>
                        <th>Personal Email Address</th>
                        <td>{{$accountsection->applicant_email_address}}</td>
                    </tr>
                    <tr>
                        <th>Secondary Personal Email Address</th>
                        <td>{{$accountsection->secondary_personal_email}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="insurance" class="tab-pane fade" role="tabpanel" aria-labelledby="insurance-tab">
            <!-- Insurance Information Content -->
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Insurance Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Insurance Type</th>
                        <td>{{ $accountsection->insurance_type }}</td>
                    </tr>
                    <tr>
                        <th>Client Status</th>
                        <td>{{ $accountsection->lives_2022 }}</td>
                    </tr>
                    <tr>
                        <th>Insurer</th>
                        <td>{{$accountsection->insurer}}</td>
                    </tr>
                    <tr>
                        <th>Type of Cover</th>
                        <td>{{$accountsection->cover}}</td>
                    </tr>
                    <tr>
                        <th>Product Type</th>
                        <td>{{$accountsection->product_type}}</td>
                    </tr>
                    <tr>
                        <th>Deductible / Excess / Cost Share / OOPM / Co-Payment</th>
                        <td>{{$accountsection->payment}}</td>
                    </tr>
                    <tr>
                        <th>Group Name</th>
                        <td>{{$accountsection->group_name}}</td>
                    </tr>
                    <tr>
                        <th>Group Number</th>
                        <td>{{$accountsection->group_number}}</td>
                    </tr>
                    <tr>
                        <th>Group Identifier</th>
                        <td>{{$accountsection->group_identifier}}</td>
                    </tr>
                    <tr>
                        <th>Type of Applicant</th>
                        <td>{{$accountsection->type_applicant}}</td>
                    </tr>
                    <tr>
                        <th>Main Applicant of Dependents</th>
                        <td>{{$accountsection->main_applicant_deps}}</td>
                    </tr>
                    <tr>
                        <th>Original Date Joined</th>
                        <td>{{$accountsection->original_date}}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{$accountsection->start_date}}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{$accountsection->end_date}}</td>
                    </tr>
                    <tr>
                        <th>Cancelled Date</th>
                        <td>{{$accountsection->cancelled_date}}</td>
                    </tr>
                    <tr>
                        <th>Reason for Cancellation</th>
                        <td>{{$accountsection->cancelled_remarks}}</td>
                    </tr>
                    <tr>
                        <th>Primary Contact Person's Email Address</th>
                        <td>{{$accountsection->email_address}}</td>
                    </tr>
                    <tr>
                        <th>Secondary Contact Person's Email Address</th>
                        <td>{{$accountsection->secondary_contact_person_email}}</td>
                    </tr>
                    <tr>
                        <th>Credentials Submitted</th>
                        <td>{{ $accountsection->credentials }}</td>
                    </tr>
                    <tr>
                        <th>Area of Cover</th>
                        <td>{{ $accountsection->area_cover }}</td>
                    </tr>
                    <tr>
                        <th>Pro-rated Premium Amount</th>
                        <td>{{$accountsection->pro_rated_premium}}</td>
                    </tr>
                    <tr>
                        <th>Premium Amount</th>
                        <td>{{$accountsection->premium}}</td>
                    </tr>
                    <tr>
                        <th>Active Premium Amount</th>
                        <td>{{$accountsection->active_premium}}</td>
                    </tr>
                    <tr>
                        <th>Frequency Premium</th>
                        <td>{{$accountsection->frequency_premium}}</td>
                    </tr>
                    <tr>
                        <th>Convert Premium to USD</th>
                        <td>{{ $accountsection->convert_premium_USD }}</td>
                    </tr>
                    <tr>
                        <th>Payment Frequency</th>
                        <td>{{$accountsection->payment_frequency}}</td>
                    </tr>
                    <tr>
                        <th>Mode of Payment</th>
                        <td>{{$accountsection->mode_payment}}</td>
                    </tr>
                    <tr>
                        <th>Subscription Currency</th>
                        <td>{{$accountsection->subscription_currency}}</td>
                    </tr>
                    <tr>
                        <th>Medical818 Premium Amount</th>
                        <td>{{$accountsection->medical818_prem_account}}</td>
                    </tr>
                    <tr>
                        <th>Medical818 Premium Amount (USD)</th>
                        <td>{{$accountsection->medical818_prem_account_USD}}</td>
                    </tr>
                    <tr>
                        <th>Medical818 Admin Fee</th>
                        <td>{{$accountsection->medical818_admin}}</td>
                    </tr>
                    <tr>
                        <th>Loading Percentage</th>
                        <td>{{ $accountsection->percentage_loading_2022 }}</td>
                    </tr>
                    <tr>
                        <th>Company Product Discount</th>
                        <td>{{ $accountsection->company_product_discount }}</td>
                    </tr>
                    <tr>
                        <th>Further Discount</th>
                        <td>{{ $accountsection->further_discount }}</td>
                    </tr>
                    <tr>
                        <th>Policy Status</th>
                        <td>{{$accountsection->policy}}</td>
                    </tr>
                    <tr>
                        <th>Case Closed by</th>
                        <td>{{$accountsection->case_closed}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="renewal" class="tab-pane fade" role="tabpanel" aria-labelledby="renewal-tab">
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Renewal Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Renewal Date</th>
                        <td>{{ $accountsection->renewal_date }}</td>
                    </tr>
                    <tr>
                        <th>Case Officer Handling Renewal</th>
                        <td>{{ $accountsection->case_officer_2022 }}</td>
                    </tr>
                    <tr>
                        <th>Renewal Discount 2022</th>
                        <td>{{ $accountsection->renewal_discount_2022 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="placement" class="tab-pane fade" role="tabpanel" aria-labelledby="placement-tab">
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Placement Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Placement Handled by</th>
                        <td>{{ $accountsection->placement_done }}</td>
                    </tr>
                    <tr>
                        <th>Placement Date</th>
                        <td>{{ $accountsection->placement_date }}</td>
                    </tr>
                    <tr>
                        <th>Broker Account</th>
                        <td>{{ $accountsection->account }}</td>
                    </tr>
                    <tr>
                        <th>Account Code</th>
                        <td>{{ $accountsection->account_code }}</td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>{{ $accountsection->payment_status }}</td>
                    </tr>
                    @if(auth()->user()->role == '1' || auth()->user()->role == '2')
                    <tr>
                        <th>Commission Percentage</th>
                        <td>{{ $accountsection->percentage_commission }}</td>
                    </tr>
                    <tr>
                        <th>Total Commission</th>
                        <td>{{ $accountsection->commission_2022 }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div id="source" class="tab-pane fade" role="tabpanel" aria-labelledby="source-tab">
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Source Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Source of Inquiry</th>
                        <td>{{ $accountsection->source_inquiry }}</td>
                    </tr>
                    <tr>
                        <th>Referral Name</th>
                        <td>{{ $accountsection->referral_name }}</td>
                    </tr>
                    <tr>
                        <th>Sub-Agent Name</th>
                        <td>{{ $accountsection->sub_agents_name }}</td>
                    </tr>
                    <tr>
                        <th>Sub-Agent Percentage Commission</th>
                        <td>{{ $accountsection->sub_agent_percentage }}</td>
                    </tr>
                    <tr>
                        <th>Commission Paid to Sub-Agent</th>
                        <td>{{ $accountsection->commission_paid }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if(auth()->user()->role == '1' || auth()->user()->role == '2')
        <div id="claims" class="tab-pane fade" role="tabpanel" aria-labelledby="claims-tab">
            @if (!empty($claimsByCurrency))
                @foreach ($claimsByCurrency as $currency => $data)
                <h3>{{ $currency }} Currency</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Assigned To</th>
                            <th>Claim Type</th>
                            <th>Status</th>
                            <th>Date Received</th>
                            <th>Currency</th>
                            <th>Paid Amount by Insurer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['claims'] as $claim)
                        @if ($claim['status'] !== 'Submitted')
                        <tr>
                            <td>
                                @if (isset($claim['user']))
                                {{ $claim['user']['first_name'] }} {{ $claim['user']['last_name'] }}
                                @else
                                Not Assigned
                                @endif
                            </td>
                            <td>{{ $claim['type'] }}</td>
                            <td>{{ $claim['status'] }}</td>
                            <td>{{ $claim['date_received'] }}</td>
                            <td>{{ $claim['currency'] }}</td>
                            <td>{{ number_format((float) str_replace(',', '', $claim['paid_amount']), 2) }}</td>
                        </tr>
                        @endif
                        @endforeach
                        <tr class="table-info">
                            <th colspan="5">Total for {{ $currency }}</th>
                            <th>{{ number_format($data['paid_amount'], 2) }}</th>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            @else
            <div class="tab-pane fade show active" id="claims" role="tabpanel" aria-labelledby="claims-tab">
                <div class="empty-message">
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    No claims data available.
                </div>
            </div>
            @endif
        </div>

    @endif

        <div id="others" class="tab-pane fade" role="tabpanel" aria-labelledby="others-tab">
            <table>
                <thead>
                    <tr class="theader">
                        <th colspan="2">Others</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Encoded By</th>
                        <td>{{ $accountsection->encoded_by }}</td>
                    </tr>
                    <tr>
                        <th>Updated By</th>
                        <td>{{ $accountsection->updated_by }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $accountsection->status }}</td>
                    </tr>
                    <tr>
                        <th>Missing Remarks</th>
                        <td>{{ $accountsection->missing_remarks }}</td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>{{ $accountsection->remarks }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var formId = 'delete-form-' + this.dataset.id;
            var form = document.getElementById(formId);

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
                    form.submit();
                }
            });
        });
    });
});

$(document).ready(function(){
    $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $(event.target).text(); // active tab
        var y = $(event.relatedTarget).text(); // previous tab
        $(".act span").text(x);
        $(".prev span").text(y);
    });
});
</script>


@endsection
