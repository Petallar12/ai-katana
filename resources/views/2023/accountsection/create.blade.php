@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset('css/create.css') }}">

<div class="table-wrapper">
    <div class="button">
        <!-- Back Button -->
        <a href="javascript:history.back()" title="Go Back"><i class="fa-solid fa-circle-arrow-left"></i></a>

        <!-- Save Button -->
        <button type="submit" title="Save" form="main-form"><i class="fa-solid fa-floppy-disk"></i></button>

        <!-- Clear Button -->
        <button type="button" id="clear-storage" title="Erase"><i class="fa-solid fa-eraser"></i></button>
    </div>

     <div class="card-x">
        <p class="card-x-header">Add Client 2023</p>
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
    <form id="main-form" action="{{ url('2023/accountsection') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <!-- TAB CONTENT -->
        <div class="tab-content">
            <p class="required-head">Note: * Required field</p>

            <!-- PERSONAL INFORMATION -->
            <div id="personal" class="tab-pane fade show active" role="tabpanel" aria-labelledby="personal-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="membership">Membership Number</label>
                        <input class="field-data" type="text" id="smalll-input" name="membership" id="membership" placeholder="Enter membership number">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="title">Title</label>
                        <select class="field-data" name="title" id="dropdown">
                            <option value="" disabled selected>Select title</option>
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
                        <label class="field-label">Full Name<span class="required">*</span></label>
                        <input class="field-data" type="text" name="full" placeholder="Enter full name" required>
                    </div>

                    <div class="field-info">
                        <label class="field-label">First Name</label>
                        <input class="field-data" type="text" name="first" placeholder="Enter first name" />
                    </div>

                    <div class="field-info">
                        <label class="field-label">Family Name</label>
                        <input class="field-data" type="text" name="family" placeholder="Enter family name" />
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="gender">Gender</label>
                        <select class="field-data" id="dropdown" name="gender">
                            <option value="" disabled selected>Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Birthday</label>
                        <input class="field-data" type="date" name="birthday" placeholder="Enter birthday" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Age</label>
                        <input class="field-data" type="number" name="age" placeholder="Enter age">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="country_nationality">Country of Nationality</label>
                        <select class="field-data" id="country_nationality" name="country_nationality">
                            <option value="" disabled selected>
                                <!-- Option is taken from json/countries.json -->
                                Select country</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="country_residence">Country of Residence</label>
                        <select class="field-data" id="country_residence" name="country_residence">
                            <option value="" disabled selected>
                                <!-- Option is taken from json/countries.json -->
                                Select residence</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Residence Address</label>
                        <input class="field-data" type="text" name="residence" placeholder="Enter residence address">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Mailing Address</label>
                        <input class="field-data" type="text" name="mailing_address" placeholder="Enter mailing address">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Contact Number</label>
                        <input class="field-data" type="float" name="contact_number" placeholder="Enter primary contact number">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Contact Number</label>
                        <input class="field-data" type="float" name="secondary_contact_number" placeholder="Enter secondary contact number">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Personal Email Address</label>
                        <input class="field-data" type="email" name="applicant_email_address" placeholder="Enter primary personal email address">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Personal Email Address</label>
                        <input class="field-data" type="email" name="secondary_personal_email" placeholder="Enter secondary personal email address">
                    </div>

                </div>
            </div>

            <!-- INSURANCE INFORMATION -->
            <div id="insurance" class="tab-pane fade" role="tabpanel" aria-labelledby="insurance-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="insurance_type">Insurance Type<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="insurance_type" required>
                            <option value="" disabled selected>Select insurance type</option>
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
                        <label class="field-label" for="lives_2023">Client Status<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="lives_2023" required>
                            <option value="" disabled selected>Select client status</option>
                            <option value="New Lives">New Lives</option>
                            <option value="Existing">Existing</option>
                            <option value="New Lives and Existing">New Lives and Existing</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="insurer">Insurer</label>
                        <select class="field-data" id="insurer" name="insurer">
                            <!-- Option is taken from json/insurer.json -->
                            <option value="" disabled selected>Select insurer</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Type of Cover</label>
                        <input class="field-data" type="text" name="cover" placeholder="Enter type of cover">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Product Type</label>
                        <input class="field-data" type="text" name="product_type" placeholder="Enter product type">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Deductible / Excess / Cost Share / OOPM / Co-Payment</label>
                        <input class="field-data" type="text" name="payment" placeholder="Enter deductibles">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Group Name</label>
                        <input class="field-data" type="text" name="group_name" placeholder="Enter group name">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Group Number</label>
                        <input class="field-data" type="text" name="group_number" placeholder="Enter group number">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="group_identifier">Group Identifier<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="group_identifier" required>
                            <option value="" disabled selected>Select group identifier</option>
                            <option value="Individual">Individual</option>
                            <option value="Group">Group</option>
                            <option value="HR Group">HR Group</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="type_applicant">Type of Applicant<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="type_applicant" required>
                            <option value="" disabled selected>Select type of applicant</option>
                            <option value="Dependent">Dependent</option>
                            <option value="Main Applicant">Main Applicant</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Main Applicant of Dependents</label>
                        <input class="field-data" type="text" name="main_applicant_deps" placeholder="Enter the name of main applicant">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Original Joined Date<span class="required">*</span></label>
                        <input class="field-data" type="date" name="original_date" placeholder="Enter original joined date" maxlength="10" min="1900-01-01" max="2100-12-31" required>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Start Date</label>
                        <input class="field-data" type="date" name="start_date" placeholder="Enter start date" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">End Date</label>
                        <input class="field-data" type="date" name="end_date" placeholder="Enter end date" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Cancelled Date</label>
                        <input class="field-data" type="date" name="cancelled_date" placeholder="Enter cancelled date" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Reason for Cancellation</label>
                        <input class="field-data" type="text" name="cancelled_remarks" placeholder="Enter reason for cancellation">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Primary Contact Person's Email Address</label>
                        <input class="field-data" type="email" name="email_address" placeholder="Enter contact person's email address">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Secondary Contact Person's Email Address</label>
                        <input class="field-data" type="email" name="secondary_contact_person_email" placeholder="Enter secondary contact person's email address">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Credentials Submitted</label>
                        <input class="field-data" type="text" name="credentials" placeholder="Enter credentials submitted">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Area of Cover</label>
                        <input class="field-data" type="text" name="area_cover" placeholder="Enter area of cover">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Pro-rated Premium Amount</label>
                        <input class="field-data" type="float" name="pro_rated_premium" placeholder="Enter pro-rated premium amount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Premium Amount</label>
                        <input class="field-data" type="float" name="premium" placeholder="Enter premium amount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Active Premium Amount</label>
                        <input class="field-data" type="float" name="active_premium" placeholder="Enter active premium amount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Frequency Premium</label>
                        <input class="field-data" type="float" name="frequency_premium" placeholder="Enter frequency amount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Convert Premium to USD</label>
                        <input class="field-data" type="float" name="convert_premium_USD" placeholder="Enter premium in USD">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="payment_frequency">Payment Frequency</label>
                        <select class="field-data" id="dropdown" name="payment_frequency">
                            <option value="" disabled selected>Select payment frequency</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Semi-Annually">Semi-Annually</option>
                            <option value="Annually">Annually</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="mode_payment">Mode of Payment</label>
                        <select class="field-data" id="dropdown" name="mode_payment">
                            <option value="" disabled selected>Select mode of payment</option>
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
                            <option value="" disabled selected>Select subscription currency</option>
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
                        <input class="field-data" type="float" name="medical818_prem_account" placeholder="Enter Medical818 premium amount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Medical818 Premium Amount (USD)</label>
                        <input class="field-data" type="float" name="medical818_prem_account_USD" placeholder="Enter Medical818 premium amount in USD">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Medical818 Admin Fee</label>
                        <input class="field-data" type="float" name="medical818_admin" placeholder="Enter Medical818 admin fee">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Loading Percentage</label>
                        <input class="field-data" type="text" name="percentage_loading_2023" placeholder="Enter loading percentage">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Company Product Discount</label>
                        <input class="field-data" type="text" name="company_product_discount" placeholder="Enter company product discount">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Further Discount</label>
                        <input class="field-data" type="text" name="further_discount" placeholder="Enter further discount">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="policy">Policy Status<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="policy" required>
                            <option value="" disabled selected>Select policy status</option>
                            <option value="Active">Active</option>
                            <option value="Lapsed">Lapsed</option>
                            <option value="Pended">Pended</option>
                            <option value="Transferred">Transferred</option>
                            <option value="Suspended">Suspended</option>
                            <option value="No Sale">No Sale</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="case_closed">Case Closed By<span class="required">*</span></label>
                        <select class="field-data" id="case_closed" name="case_closed" required>
                            <!-- Taken from JSON file -->
                            <option value="" disabled selected>Case case officer</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- RENEWAL INFORMATION -->
            <div id="renewal" class="tab-pane fade" role="tabpanel" aria-labelledby="renewal-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label">Renewal Date</label>
                        <input class="field-data" type="date" name="renewal_date" placeholder="Enter renewal date" maxlength="10" min="1900-01-01" max="2100-12-31">
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="case_officer_2023">Case Officer Handling Renewal</label>
                        <select class="field-data" id="renewal_closed" name="case_officer_2023">
                            <option value="" disabled selected>Select case officer</option>
                            <!-- Add your options here -->
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Renewal Discount</label>
                        <input class="field-data" type="text" name="renewal_discount_2023" placeholder="Enter renewal discount">
                    </div>
                </div>
            </div>

            <!-- PLACEMENT INFORMATION -->
            <div id="placement" class="tab-pane fade" role="tabpanel" aria-labelledby="placement-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="placement_done">Placement Handled by<span class="required">*</span></label>
                        <select class="field-data" id="placement_done" name="placement_done" required>
                            <option value="" disabled selected>Select placement staff</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Placement Date<span class="required">*</span></label>
                        <input class="field-data" type="date" name="placement_date" placeholder="Enter placement date" maxlength="10" min="1900-01-01" max="2100-12-31" required>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="account">Broker Account</label>
                        <select class="field-data" id="dropdown" name="account">
                            <option value="" disabled selected>Select broker account</option>
                            <option value="Rig Associates Pte Ltd">Rig Associates Pte Ltd</option>
                            <option value="Bricon Associates Pte Ltd">Bricon Associates Pte Ltd</option>
                            <option value="Jusmedical Sdn Bhd">Jusmedical Sdn Bhd</option>
                            <option value="PT Luke Medikal Internasional ">PT Luke Medikal Internasional </option>
                            <option value="Bricon Associates ">Bricon Associates </option>
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
                            <option value="" disabled selected>Select account code</option>
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
                            <option value="" disabled selected>Select payment status</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Percentage</label>
                        <input class="field-data" type="float" name="percentage_commission" placeholder="Enter commission percentage">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Received</label>
                        <input class="field-data" type="float" name="commission_2023" placeholder="Enter commission received">
                    </div>
                   
                </div>
            </div>

            <!-- SOURCE INFORMATION -->
            <div id="source" class="tab-pane fade" role="tabpanel" aria-labelledby="source-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label" for="source_inquiry">Source of Inquiry<span class="required">*</span></label>
                        <select class="field-data" id="dropdown" name="source_inquiry" required>
                            <option value="" disabled selected>Select source of inquiry</option>
                            <option value="No Record">No Record</option>
                            <option value="Web Leads">Web Leads</option>
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
                        <input class="field-data" type="text" name="referral_name" placeholder="Enter referral name">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Sub-Agent Name</label>
                        <input class="field-data" type="text" name="sub_agents_name" placeholder="Enter sub-agent name">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Sub-Agent Percentage Commission</label>
                        <input class="field-data" type="text" name="sub_agent_percentage" placeholder="Enter sub-agent percentage commission">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Commission Paid to Sub-Agent</label>
                        <input class="field-data" type="text" name="commission_paid" placeholder="Enter commission paid to sub-agent">
                    </div>

                </div>
            </div>

            <!-- ATTACHMENT INFORMATION -->
            <div id="attachment" class="tab-pane fade" role="tabpanel" aria-labelledby="attachment-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label">Membership Certificate</label>
                        <input class="field-attachment" type="file" name="file" id="file" accept=".pdf, .doc, .docx" class="form-control">
                         @error('file')
                        {{ $message }}
                        @enderror
                    </div>

                    <div class="field-info">
                        <label class="field-label">Invoice</label>
                        <input class="field-attachment" type="file" name="file2" id="file2" accept=".pdf, .doc, .docx" class="form-control">
                        @error('file2')
                        {{ $message }}
                        @enderror
                    </div>

                    <div class="field-info">
                        <label class="field-label">Application Form</label>
                        <input class="field-attachment" type="file" name="file3" id="file3" accept=".pdf, .doc, .docx" class="form-control">
                        @error('file3')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- OTHER INFORMATION -->
            <div id="others" class="tab-pane fade" role="tabpanel" aria-labelledby="others-tab">
                <div class="form-wrapper">

                    <div class="field-info">
                        <label class="field-label">Encoded by</label>
                        <input class="field-data" type="text" name="encoded_by" value="{{ Auth::user()->name }}"  readonly>
                    </div>

                    <div class="field-info">
                        <label class="field-label" for="status">Encoded Data Status</label>
                        <select class="field-data" id="dropdown" name="status">
                            <option value="" disabled selected>Select encoded data status</option>
                            <option value="Complete">Complete</option>
                            <option value="Incomplete">Incomplete</option>
                            <option value="Not Counted">Not Counted</option>
                        </select>
                    </div>

                    <div class="field-info">
                        <label class="field-label">Missing Remarks</label>
                        <input class="field-data" type="text" name="missing_remarks" placeholder="Enter missing remarks">
                    </div>

                    <div class="field-info">
                        <label class="field-label">Remarks</label>
                        <input class="field-data" type="text" name="remarks" placeholder="Enter remarks">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('js/editBlade.js') }}"></script>
<script src="{{ asset('js/formValidationCreate.js') }}"></script>

@endsection


