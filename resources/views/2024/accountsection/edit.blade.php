@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset('css/edit.css') }}">

<div class="table-wrapper">
    <div class="button">
        <!-- Back Button -->
        <a href="javascript:history.back()" title="Go Back"><i class="fa-solid fa-circle-arrow-left"></i></a>

        <!-- Delete Button -->
        <a href="#" class="delete-link" data-id="{{ $accountsection_2024->id }}" title="Delete Client"><i class="fa-solid fa-circle-minus"></i></a>
        <form id="delete-form-{{ $accountsection_2024->id }}" method="POST" action="{{ url('/2024/accountsection/' . $accountsection_2024->id) }}" accept-charset="UTF-8" style="display:none">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
        </form>

        <!-- Save Button -->
        <button type="submit" title="Save" form="main-form"><i class="fa-solid fa-floppy-disk"></i></button>
    </div>

    <div class="card-x">
        <p class="card-x-header">Edit Client:</p><h2>{{ $accountsection_2024->full }}</h2>
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
            <li class="nav-item">
                <a class="nav-link" id="attachment-tab" data-bs-toggle="tab" href="#attachment" role="tab" aria-controls="attachment" aria-selected="false">Attachment<br>Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="others-tab" data-bs-toggle="tab" href="#others" role="tab" aria-controls="others" aria-selected="false">Other<br>Information</a>
            </li>
        </ul>
    </div>

    <!-- FORM START -->
    <form id="main-form" action="/2024/accountsection/{{ $accountsection_2024->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- TAB CONTENT -->
        <div class="tab-content">

            <!-- PERSONAL INFORMATION -->
            <div id="personal" class="tab-pane fade show active" role="tabpanel" aria-labelledby="personal-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="membership">Membership Number</label>
                        <input class="field-data" type="text" id="smalll-input" name="membership" id="membership" value="{{$accountsection_2024->membership}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="title">Title</label>
                        <select class="field-data" name="title" id="dropdown">
                            <option value="" disabled selected>{{$accountsection_2024->title}}</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Miss">Miss</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Col.">Col.</option>
                            <option value="Madam">Madam</option>
                            <option value="Executors of">Executors of</option>
                            <option value="MSgt.">MSgt</option>
                            <option value="Master">Master</option>
                            <option value="TSgt.">TSgt</option>
                            <option value="Professor">Professor</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Full Name</label>
                        <input class="field-data" type="text" name="full" value="{{$accountsection_2024->full}}" required>
                    </div>

                    <div class="field-info">
                        <label class="field-label">First Name</label>
                        <input class="field-data" type="text" name="first" value="{{$accountsection_2024->first}}" />
                    </div>

                    <div class="field-info">
                        <label class="field-label">Family Name</label>
                        <input class="field-data" type="text" name="family" value="{{$accountsection_2024->family}}" />
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="gender">Gender</label>
                        <select class="field-data" id="dropdown" name="gender">
                            <option value="" disabled selected>{{$accountsection_2024->gender}}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Birthday</label>
                        <input class="field-data" type="date" name="birthday" value="{{$accountsection_2024->birthday}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Age</label>
                        <input class="field-data" type="number" name="age" value="{{$accountsection_2024->age}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="country_nationality">Country of Nationality</label>
                        <select class="field-data" id="country_nationality" name="country_nationality">
                            <option value="" disabled selected>
                                <!-- Option is taken from json/countries.json -->
                                {{$accountsection_2024->country_nationality}}</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="country_residence">Country of Residence</label>
                        <select class="field-data" id="country_residence" name="country_residence">
                            <option value="" disabled selected>
                                <!-- Option is taken from json/countries.json -->
                                {{$accountsection_2024->country_residence}}</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Residence Address</label>
                        <input class="field-data" type="text" name="residence" value="{{$accountsection_2024->residence}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Mailing Address</label>
                        <input class="field-data" type="text" name="mailing_address" value="{{$accountsection_2024->mailing_address}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Contact Number</label>
                        <input class="field-data" type="float" name="contact_number" value="{{$accountsection_2024->contact_number}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Contact Number</label>
                        <input class="field-data" type="float" name="secondary_contact_number" value="{{$accountsection_2024->secondary_contact_number}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Personal Email Address</label>
                        <input class="field-data" type="email" name="applicant_email_address" value="{{$accountsection_2024->applicant_email_address}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Personal Email Address</label>
                        <input class="field-data" type="email" name="secondary_personal_email" value="{{$accountsection_2024->secondary_personal_email}}">
                    </div>
                </div>
            </div>

            <!-- INSURANCE INFORMATION -->
            <div id="insurance" class="tab-pane fade" role="tabpanel" aria-labelledby="insurance-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="insurance_type">Insurance Type</label>
                        <select class="field-data" id="dropdown" name="insurance_type">
                            <option value="" disabled selected>{{$accountsection_2024->insurance_type}}</option>
                            <option value="IPMI">IPMI</option>
                            <option value="Local Medical/Health Insurance">Local Medical/Health Insurance</option>
                            <option value="Home Insurance">Home Insurance</option>
                            <option value="Personal Accident">Personal Accident</option>
                            <option value="Car/Vehicle Insurance">Car/Vehicle Insurance</option>
                            <option value="Helper/Maid Insurance">Helper/Maid Insurance</option>
                            <option value="Travel Insurance">Travel Insurance</option>
                            <option value="Property Insurance">Property Insurance</option>
                            <option value="Fire Insurance">Fire Insurance</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="lives_2024">Client Status</label>
                        <select class="field-data" id="dropdown" name="lives_2024">
                            <option value="" disabled selected>{{$accountsection_2024->lives_2024}}</option>
                            <option value="New Lives">New Lives</option>
                            <option value="Existing">Existing</option>
                            <option value="New Lives and Existing">New Lives and Existing</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="insurer">Insurer</label>
                        <select class="field-data" id="insurer" name="insurer">
                            <!-- Option is taken from json/insurer.json -->
                            <option value="" disabled selected>{{$accountsection_2024->insurer}}</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Type of Cover</label>
                        <input class="field-data" type="text" name="cover" value="{{$accountsection_2024->cover}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Product Type</label>
                        <input class="field-data" type="text" name="product_type" value="{{$accountsection_2024->product_type}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Deductible / Excess / Cost Share / OOPM / Co-Payment</label>
                        <input class="field-data" type="text" name="payment" value="{{$accountsection_2024->payment}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Group Name</label>
                        <input class="field-data" type="text" name="group_name" value="{{$accountsection_2024->group_name}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Group Number</label>
                        <input class="field-data" type="text" name="group_number" value="{{$accountsection_2024->group_number}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="group_identifier">Group Identifier</label>
                        <select class="field-data" id="dropdown" name="group_identifier">
                            <option value="" disabled selected>{{$accountsection_2024->group_identifier}}</option>
                            <option value="Individual">Individual</option>
                            <option value="Group">Group</option>
                            <option value="HR Group">HR Group</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="type_applicant">Type of Applicant</label>
                        <select class="field-data" id="dropdown" name="type_applicant">
                            <option value="" disabled selected>{{$accountsection_2024->type_applicant}}</option>
                            <option value="Dependent">Dependent</option>
                            <option value="Main Applicant">Main Applicant</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Main Applicant of Dependents</label>
                        <input class="field-data" type="text" name="main_applicant_deps" value="{{$accountsection_2024->main_applicant_deps}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Original Joined Date</label>
                        <input class="field-data" type="date" name="original_date" value="{{$accountsection_2024->original_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Start Date</label>
                        <input class="field-data" type="date" name="start_date" value="{{$accountsection_2024->start_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">End Date</label>
                        <input class="field-data" type="date" name="end_date" value="{{$accountsection_2024->end_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Cancelled Date</label>
                        <input class="field-data" type="date" name="cancelled_date" value="{{$accountsection_2024->cancelled_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Reason for Cancellation</label>
                        <input class="field-data" type="text" name="cancelled_remarks" value="{{$accountsection_2024->cancelled_remarks}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Contact Person's Email Address</label>
                        <input class="field-data" type="email" name="email_address" value="{{$accountsection_2024->email_address}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Contact Person's Email Address</label>
                        <input class="field-data" type="email" name="secondary_contact_person_email" value="{{$accountsection_2024->secondary_contact_person_email}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Credentials Submitted</label>
                        <input class="field-data" type="text" name="credentials" value="{{$accountsection_2024->credentials}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Area of Cover</label>
                        <input class="field-data" type="text" name="area_cover" value="{{$accountsection_2024->area_cover}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Pro-rated Premium Amount</label>
                        <input class="field-data" type="float" name="pro_rated_premium" value="{{$accountsection_2024->pro_rated_premium}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Premium Amount</label>
                        <input class="field-data" type="float" name="premium" value="{{$accountsection_2024->premium}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Active Premium Amount</label>
                        <input class="field-data" type="float" name="active_premium" value="{{$accountsection_2024->active_premium}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Frequency Premium</label>
                        <input class="field-data" type="float" name="frequency_premium" value="{{$accountsection_2024->frequency_premium}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Convert Premium to USD</label>
                        <input class="field-data" type="float" name="convert_premium_USD" value="{{$accountsection_2024->convert_premium_USD}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="payment_frequency">Payment Frequency</label>
                        <select class="field-data" id="dropdown" name="payment_frequency">
                            <option value="" disabled selected>{{$accountsection_2024->payment_frequency}}</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Semi-Annually">Semi-Annually</option>
                            <option value="Annually">Annually</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="mode_payment">Mode of Payment</label>
                        <select class="field-data" id="dropdown" name="mode_payment">
                            <option value="" disabled selected>{{$accountsection_2024->mode_payment}}</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Direct Debit">Direct Debit</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="subscription_currency">Subscription Currency</label>
                        <select class="field-data" id="dropdown" name="subscription_currency">
                            <option value="" disabled selected>{{$accountsection_2024->subscription_currency}}</option>
                            <option value="AED">AED</option>
                            <option value="USD">USD</option>
                            <option value="SGD">SGD</option>
                            <option value="IDR">IDR</option>
                            <option value="GBP">GBP</option>
                            <option value="EUR">EUR</option>
                            <option value="PHP">PHP</option>
                            <option value="AUD">AUD</option>
                            <option value="DKK">DKK</option>
                            <option value="VND">VND</option>
                            <option value="THB">THB</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Medical818 Premium Amount</label>
                        <input class="field-data" type="float" name="medical818_prem_account" value="{{$accountsection_2024->medical818_prem_account}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Medical818 Premium Amount (USD)</label>
                        <input class="field-data" type="float" name="medical818_prem_account_USD" value="{{$accountsection_2024->medical818_prem_account_USD}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Medical818 Admin Fee</label>
                        <input class="field-data" type="float" name="medical818_admin" value="{{$accountsection_2024->medical818_admin}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Loading Percentage</label>
                        <input class="field-data" type="text" name="percentage_loading_2024" value="{{$accountsection_2024->percentage_loading_2024}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Company Product Discount</label>
                        <input class="field-data" type="text" name="company_product_discount" value="{{$accountsection_2024->company_product_discount}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Further Discount</label>
                        <input class="field-data" type="text" name="further_discount" value="{{$accountsection_2024->further_discount}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="policy">Policy Status</label>
                        <select class="field-data" id="dropdown" name="policy">
                            <option value="" disabled selected>{{$accountsection_2024->policy}}</option>
                            <option value="Active">Active</option>
                            <option value="Lapsed">Lapsed</option>
                            <option value="Pended">Pended</option>
                            <option value="Transferred">Transferred</option>
                            <option value="Suspended">Suspended</option>
                            <option value="No Sale">No Sale</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="case_closed">Case Closed By</label>
                        <select class="field-data" id="case_closed" name="case_closed">
                            <!-- Taken from JSON file -->
                            <option value="" disabled selected>{{$accountsection_2024->case_closed}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- RENEWAL INFORMATION -->
            <div id="renewal" class="tab-pane fade" role="tabpanel" aria-labelledby="renewal-tab">
                <div class="form-wrapper">
                    <div class="field-info">
                        <label class="field-label">Renewal Date</label>
                        <input class="field-data" type="date" name="renewal_date" value="{{$accountsection_2024->renewal_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="renewal_closed">Case Officer Handling Renewal</label>
                        <select class="field-data" id="renewal_closed" name="case_officer_2024">
                            <!-- Taken from JSON file -->
                            <option value="" disabled selected>{{$accountsection_2024->case_officer_2024}}</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Renewal Discount</label>
                        <input class="field-data" type="text" name="renewal_discount_2024" value="{{$accountsection_2024->renewal_discount_2024}}">
                    </div>
                </div>
            </div>

            <!-- PLACEMENT INFORMATION -->
            <div id="placement" class="tab-pane fade" role="tabpanel" aria-labelledby="placement-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="placement_done">Placement Handled by</label>
                        <select class="field-data" id="placement_done" name="placement_done">
                            <option value="" disabled selected>{{$accountsection_2024->placement_done}}</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Placement Date</label>
                        <input class="field-data" type="date" name="placement_date" value="{{$accountsection_2024->placement_date}}" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="account">Broker Account</label>
                        <select class="field-data" id="dropdown" name="account">
                            <option value="" disabled selected>{{$accountsection_2024->account}}</option>
                            <option value="Financial Alliance Pte Ltd/Briony">Financial Alliance Pte Ltd/Briony</option>
                            <option value="Rig Associates Pte Ltd">Rig Associates Pte Ltd</option>
                            <option value="Bricon Associates Pte Ltd">Bricon Associates Pte Ltd</option>
                            <option value="Jusmedical Sdn Bhd">Jusmedical Sdn Bhd</option>
                            <option value="PT Luke Medikal Internasional">PT Luke Medikal Internasional</option>
                            <option value="Bricon Associates">Bricon Associates</option>
                            <option value="Juscall International Inc">Juscall International Inc</option>
                            <option value="Luke International Consultant Company Ltd">Luke International Consultant Company Ltd</option>
                            <option value="Juscall Insurance Agency Inc">Juscall Insurance Agency Inc</option>
                            <option value="Luke Medical Pte Ltd">Luke Medical Pte Ltd</option>
                            <option value="Medishure Global">Medishure Global</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="account_code">Account Code</label>
                        <select class="field-data" id="dropdown" name="account_code">
                            <option value="" disabled selected>{{$accountsection_2024->account_code}}</option>
                            <option value="81547">No Record</option>
                            <option value="81547">81547</option>
                            <option value="34482">34482</option>
                            <option value="37527">37527</option>
                            <option value="202200400 / 104167">202200400 / 104167</option>
                            <option value="905400000 / 98087">905400000 / 98087</option>
                            <option value="2114780">2114780</option>
                            <option value="A1956">A1956</option>
                            <option value="0008/HDDL/020/2020">0008/HDDL/020/2020</option>
                            <option value="M01LM0000">M01LM0000</option>
                            <option value="1740077">1740077</option>
                            <option value="5092805">5092805</option>
                            <option value="20154542">20154542</option>
                            <option value="MPNA497">MPNA497</option>
                            <option value="M1DLM00008">M1DLM00008</option>
                            <option value="81932">81932</option>
                            <option value="537654">537654</option>
                            <option value="MM01302">MM01302</option>
                            <option value="6754">6754</option>
                            <option value="280161">280161</option>
                            <option value="0001/2021">0001/2021</option>
                            <option value="MDC14902">MDC14902</option>
                            <option value="349100">349100</option>
                            <option value="2491">2491</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="payment_status">Payment Status</label>
                        <select class="field-data" id="dropdown" name="payment_status">
                            <option value="" disabled selected>{{$accountsection_2024->payment_status}}</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Percentage</label>
                        <input class="field-data" type="float" name="percentage_commission" value="{{$accountsection_2024->percentage_commission}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Received</label>
                        <input class="field-data" type="float" name="commission_2024" value="{{$accountsection_2024->commission_2024}}">
                    </div>
                </div>
            </div>

            <!-- SOURCE INFORMATION -->
            <div id="source" class="tab-pane fade" role="tabpanel" aria-labelledby="source-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="source_inquiry">Source of Inquiry</label>
                        <select class="field-data" id="dropdown" name="source_inquiry">
                            <option value="" disabled selected>{{$accountsection_2024->source_inquiry}}</option>
                            <option value="No Record">No Record</option>
                            <option value="Web Leads">Web Leads</option>
                            <option value="Existing Member">Existing Member</option>
                            <option value="Referred by Boss Liz">Referred by Boss Liz</option>
                            <option value="Referred by Briony">Referred by Briony</option>
                            <option value="Referred by Sub-agent">Referred by Sub-agent</option>
                            <option value="Referred by Client">Referred by Client</option>
                            <option value="Referred by Insurer">Referred by Insurer</option>
                            <option value="Relatives / Friends">Relatives / Friends</option>
                            <option value="Add-on">Add-on</option>
                            <option value="Others">Others</option>
                            <option value="Transferred from previous Insurer">Transferred from previous Insurer</option>
                            <option value="Rejoining Clients">Rejoining Clients</option>
                            <option value="Short Term Activation">Short Term Activation</option>
                            <option value="From WA / Phone">From WA / Phone</option>
                            <option value="Oil and Gas In and Out Members with or Less Than 3 Members">Oil and Gas In and Out Members with or Less Than 3 Members</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Referral Name</label>
                        <input class="field-data" type="text" name="referral_name" value="{{$accountsection_2024->referral_name}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Sub-Agent Name</label>
                        <input class="field-data" type="text" name="sub_agents_name" value="{{$accountsection_2024->sub_agents_name}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Sub-Agent Percentage Commission</label>
                        <input class="field-data" type="text" name="sub_agent_percentage" value="{{$accountsection_2024->sub_agent_percentage}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Paid to Sub-Agent</label>
                        <input class="field-data" type="text" name="commission_paid" value="{{$accountsection_2024->commission_paid}}">
                    </div>


                </div>
            </div>

            <!-- ATTACHMENT INFORMATION -->
            <div id="attachment" class="tab-pane fade" role="tabpanel" aria-labelledby="attachment-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label">Membership Certificate</label>
                        <input class="field-attachment" type="file" name="file" id="file" accept=".pdf, .doc, .docx" class="form-control">
                        <div class="attachment-label">
                            @if ($accountsection_2024->attachment)
                            <a href="{{ asset('storage/images_2024/'.$accountsection_2024->attachment) }}" class="btn btn-primary" target="_blank">{{$accountsection_2024->attachment}}</a>
                            @endif
                        </div>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Invoice</label>
                        <input class="field-attachment" type="file" name="file2" id="file2" accept=".pdf, .doc, .docx" class="form-control">
                        <div class="attachment-label">
                            @if ($accountsection_2024->attachment_2)
                            <a href="{{ asset('storage/attachment_2_2024/'.$accountsection_2024->attachment_2) }}" class="btn btn-primary" target="_blank">{{$accountsection_2024->attachment_2}}</a>
                            @endif
                        </div>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Application Form</label>
                        <input class="field-attachment" type="file" name="file3" id="file3" accept=".pdf, .doc, .docx" class="form-control">
                        <div class="attachment-label">
                            @if ($accountsection_2024->attachment_3)
                            <a href="{{ asset('storage/application_form_2024/'.$accountsection_2024->attachment_3) }}" class="btn btn-primary" target="_blank">{{$accountsection_2024->attachment_3}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- OTHER INFORMATION -->
            <div id="others" class="tab-pane fade" role="tabpanel" aria-labelledby="others-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label">Encoded by</label>
                        <input class="field-data" type="text" name="encoded_by" value="{{$accountsection_2024->encoded_by}}" readonly>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Updated by</label>
                        <input class="field-data" type="text" name="updated_by" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="status">Encoded Data Status</label>
                        <select class="field-data" id="dropdown" name="status">
                            <option value="" disabled selected>{{$accountsection_2024->status}}</option>
                            <option value="Complete">Complete</option>
                            <option value="Incomplete">Incomplete</option>
                            <option value="Not Counted">Not Counted</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Missing Remarks</label>
                        <input class="field-data" type="text" name="missing_remarks" value="{{$accountsection_2024->missing_remarks}}">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Remarks</label>
                        <input class="field-data" type="text" name="remarks" value="{{$accountsection_2024->remarks}}">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/editBlade.js') }}"></script>
<script src="{{ asset('js/formValidationEdit.js') }}"></script>

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


</script>

@endsection
