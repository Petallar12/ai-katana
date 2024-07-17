{{-- for floating buttons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 13px;
  }

  .table-wrapper {
    width: 100%;
    max-width: 960px;
    margin: 0 auto;
    padding: 20px;
    background-color: rgb(255, 255, 255, .5);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }

  table {
    width: 100%;
    border-radius: 10px;
  }

  th:first-child,
  td:first-child {
    width: 30%;
  }

  th {
    background-color: rgb(15, 15, 15, .5);
    font-weight: bold;
    color: white;
    text-align: left;

  }

  th,
  td {
    border: 1px solid #e1e1e1;
    padding: 10px;

  }


  tr:nth-child(even) {
    background-color: #f8f8f8;
  }

  tr {
    background-color: #e8e8e8;
  }

  tr:hover td {
    background: rgb(62, 131, 219);
    background: linear-gradient(90deg, rgba(62, 131, 219, 1) 0%, rgba(6, 63, 184, 1) 100%);
    color: white;
    font-weight: 500;
  }

  td {
    text-align: left;
  }

  .card {
    padding: 10px 0px 3px 0px;
    color: white;
    border-radius: 10px;
    margin-bottom: 20px;
    border: none;
    text-align: center;
    background: rgb(62, 131, 219);
    background: linear-gradient(90deg, rgba(62, 131, 219, 1) 0%, rgba(6, 63, 184, 1) 100%);

  }

  thead th {
    background-color: rgb(15, 15, 15, .5);
    text-align: center;
    color: white;
  }

  .button {
    position: fixed;
    /* height:100vh; */
    display: flex;
    flex-direction: column;
    margin-left: -160px;
    /* justify-content: center; */
  }

  .button a,
  form button {
    /* color:#fff; */
    background: rgba(240, 223, 223, 0.4);
    /* font-size:20px; */
    font-weight: 600;
    text-decoration: none;
    /* display: block; */
    margin-bottom: 8px;
    padding: 10px;
    /* width:75px; */
    text-align: center;
    border-radius: 100px;
    /* transition: 1s; */
    /* transition-property: transform; */

  }

  /* -------.button a:Hover is to make the logo move to right when swipe by mouse------- */
  /* .button a:hover{
  transform: translate(140px,0);
} */
  .button i {
    margin-left: 0px;
    font-size: 25px;
    width: 30px;
    height: 30px;

  }

  i {
    color: white;
    text-align: center;
  }

  a {
    color: white;
  }


  .button a:nth-child(1):hover {
    background: rgba(240, 223, 223, 0.8);
  }

  main,
  .main-content {
    padding-top: 70px;
    /* Adjust the value based on your navbar height */
  }



  body {
    background-image: url('/assets/images/lokeybgblur.jpg');
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
  }
</style>

<div class="table-wrapper">
  <div class="button">
    <a href="/2023/2023datagraph/index">Premium<i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    <a href="/2023/2023datagraph/total_commission">Commission<i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    {{-- <a href="{{ url('/2023/accountsection/' . $accountsection_2023->id . '/edit') }}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    <form method="POST" action="{{ url('/2023/accountsection/' . $accountsection_2023->id) }}" accept-charset="UTF-8" style="display:inline">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
      <button type="submit" title="Delete Client" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i>
      </button>
    </form> --}}
  </div>
  <div class="card">Full details of: <h2>{{ $accountsection_2023->full }}</h2>
  </div>
  <table>
    <thead>
      <div class="theader">
        <tr>
          <th></th>
          <th>Client Information</th>
        </tr>
    </thead>

    <!-- PERSONAL INFORMATION -->

    <tr>
      <th>Membership Number</th>
      <td>{{$accountsection_2023->membership}}</td>
    </tr>
    <tr>
      <th>Title</th>
      <td>{{$accountsection_2023->title}}</td>
    </tr>
    <tr>
      <th>Full Name</th>
      <td>{{$accountsection_2023->full}}</td>
    </tr>
    <tr>
      <th>First Name</th>
      <td>{{$accountsection_2023->first}}</td>
    </tr>
    <tr>
      <th>Family Name</th>
      <td>{{$accountsection_2023->family}}</td>
    </tr>
    <tr>
      <th>Gender</th>
      <td>{{$accountsection_2023->gender}}</td>
    </tr>
    <tr>
      <th>Birthday</th>
      <td>{{$accountsection_2023->birthday}}</td>
    </tr>

    {{-- get the age automatically using birthday --}}
    <?php
    $birthday = new DateTime($accountsection_2023->birthday);
    $today = new DateTime();
    $age = date_diff($birthday, $today)->y;
    ?>

    <tr>
      <th>Age</th>
      <td>{{$age}}</td>
    </tr>
    <tr>
      <th>Country of Nationality</th>
      <td>{{$accountsection_2023->country_nationality}}</td>
    </tr>
    <tr>
      <th>Current Country of Residence</th>
      <td>{{$accountsection_2023->country_residence}}</td>
    </tr>
    <tr>
      <th>Residence Address</th>
      <td>{{$accountsection_2023->residence}}</td>
    </tr>
    <tr>
      <th>Mailing Address</th>
      <td>{{$accountsection_2023->mailing_address}}</td>
    </tr>
    <tr>
      <th>Primary Contact Number</th>
      <td>{{$accountsection_2023->contact_number}}</td>
    </tr>
    <tr>
      <th>Secondary Contact Number</th>
      <td>{{$accountsection_2023->secondary_contact_number}}</td>
    </tr>
    <tr>
      <th>Personal Email Address</th>
      <td>{{$accountsection_2023->applicant_email_address}}</td>
    </tr>
    <tr>
      <th>Secondary Personal Email Address</th>
      <td>{{$accountsection_2023->secondary_personal_email}}</td>
    </tr>

    <!-- INSURANCE INFORMATION -->

    <tr>
      <th>Insurance Type</th>
      <td>{{ $accountsection_2023->insurance_type }}</td>
    </tr>
    <tr>
      <th>Client Status</th>
      <td>{{ $accountsection_2023->lives_2023 }}</td>
    </tr>
    <tr>
      <th>Insurer</th>
      <td>{{$accountsection_2023->insurer}}</td>
    </tr>
    <tr>
      <th>Type of Cover</th>
      <td>{{$accountsection_2023->cover}}</td>
    </tr>
    <tr>
      <th>Product Type</th>
      <td>{{$accountsection_2023->product_type}}</td>
    </tr>
    <tr>
      <th>Deductible / Excess / Cost Share<br>/ OOPM / Co-Payment</th>
      <td>{{$accountsection_2023->payment}}</td>
    </tr>
    <th>Group Name</th>
    <td>{{$accountsection_2023->group_name}}</td>
    </tr>
    <tr>
      <th>Group Number</th>
      <td>{{$accountsection_2023->group_number}}</td>
    </tr>
    <tr>
      <th>Current Total Members</th>
      <td>{{ $accountsection_2023->total_members_2023 }}</td>
    </tr>
    <tr>
      <th>Type of Applicant</th>
      <td>{{$accountsection_2023->type_applicant}}</td>
    </tr>
    <tr>
      <th>Main Applicant of Dependents</th>
      <td>{{$accountsection_2023->main_applicant_deps}}</td>
    </tr>
    <tr>
      <th>Original Date Joined</th>
      <td>{{$accountsection_2023->original_date}}</td>
    </tr>
    <tr>
      <th>Start Date</th>
      <td>{{$accountsection_2023->start_date}}</td>
    </tr>
    <tr>
      <th>End Date</th>
      <td>{{$accountsection_2023->end_date}}</td>
    </tr>
    <tr>
      <th>Cancelled Date</th>
      <td>{{$accountsection_2023->cancelled_date}}</td>
    </tr>
    <tr>
      <th>Reason for Cancellation</th>
      <td>{{$accountsection_2023->cancelled_remarks}}</td>
    </tr>
    <tr>
      <th>Primary Contact Person's Email Address</th>
      <td>{{$accountsection_2023->email_address}}</td>
    </tr>
    <tr>
      <th>Secondary Contact Person's Email Address</th>
      <td>{{$accountsection_2023->secondary_contact_person_email}}</td>
    </tr>
    <tr>
      <th>Credentials Submitted</th>
      <td>{{ $accountsection_2023->credentials }}</td>
    </tr>
    <tr>
      <th>Area of Cover</th>
      <td>{{ $accountsection_2023->area_cover }}</td>
    </tr>
    <tr>
      <th>Pro-rated Premium Amount</th>
      <td>{{$accountsection_2023->pro_rated_premium}}</td>
    </tr>
    <tr>
      <th>Premium Amount</th>
      <td>{{$accountsection_2023->premium}}</td>
    </tr>
    <tr>
      <th>Active Premium Amount</th>
      <td>{{$accountsection_2023->active_premium}}</td>
    </tr>
    <!-- <tr>
          <th>Active Premium Unpaid</th>
          <td>{{$accountsection_2023->active_premium_not_paid}}</td>
        </tr>  -->
    <tr>
      <th>Frequency Premium</th>
      <td>{{$accountsection_2023->frequency_premium}}</td>
    </tr>
    <tr>
      <th>Convert Premium to USD</th>
      <td>{{ $accountsection_2023->convert_premium_USD }}</td>
    </tr>
    <tr>
      <th>Payment Frequency</th>
      <td>{{$accountsection_2023->payment_frequency}}</td>
    </tr>
    <tr>
      <th>Mode of Payment</th>
      <td>{{$accountsection_2023->mode_payment}}</td>
    </tr>
    <tr>
      <th>Subscription Currency</th>
      <td>{{$accountsection_2023->subscription_currency}}</td>
    </tr>
    <tr>
      <th>Medical818 Premium Amount</th>
      <td>{{$accountsection_2023->medical818_prem_account}}</td>
    </tr>
    <tr>
      <th>Medical818 Premium Amount (USD)</th>
      <td>{{$accountsection_2023->medical818_prem_account_USD}}</td>
    </tr>
    <tr>
      <th>Medical818 Admin Fee</th>
      <td>{{$accountsection_2023->medical818_admin}}</td>
    </tr>
    <tr>
      <th>Policy Status</th>
      <td>{{$accountsection_2023->policy}}</td>
    </tr>
    <tr>
      <th>Case Closed by</th>
      <td>{{$accountsection_2023->case_closed}}</td>
    </tr>

    <!-- RENEWAL INFORMATION -->

    {{-- <tr>
          <th>Renewal Month</th>
          <td>{{ $accountsection_2023->renewal_month }}</td>
    </tr>
    <tr>
      <th>Renewal Year</th>
      <td>{{ $accountsection_2023->renewal_year }}</td>
    </tr> --}}
    <tr>
      <th>Renewal Date</th>
      <td>{{ $accountsection_2023->renewal_date }}</td>
    </tr>
    {{-- <tr>      
          <th>Renewal followed-up date</th>
          <td>{{ $accountsection_2023->renewal_follow_up }}</td>
    </tr> --}}
    <!-- <tr>
      <th>Case Officer Handling Renewal</th>
      <td>{{ $accountsection_2023->case_officer }}</td>
    </tr> -->
    <tr>
      <th>Case Officer Handling Renewal</th>
      <td>{{ $accountsection_2023->case_officer_2023 }}</td>
    </tr>

    <!-- PLACEMENT INFORMATION -->

    <tr>
      <th>Placement Handled by</th>
      <td>{{ $accountsection_2023->placement_done }}</td>
    </tr>
    <tr>
      <th>Placement Date</th>
      <td>{{ $accountsection_2023->placement_date }}</td>
    </tr>
    <tr>
      <th>Broker Account</th>
      <td>{{ $accountsection_2023->account }}</td>
    </tr>
    <tr>
      <th>Account Code</th>
      <td>{{ $accountsection_2023->account_code }}</td>
    </tr>
    <tr>
      <th>Confirmation E-mail</th>
      <td>{{ $accountsection_2023->confirmation_email }}</td>
    </tr>
    <tr>
      <th>Payment Status</th>
      <td>{{ $accountsection_2023->payment_status }}</td>
    </tr>
    <tr>
      <th>Percentage of Loading 2023</th>
      <td>{{ $accountsection_2023->percentage_loading_2023 }}</td>
    </tr>
    <tr>
      <th>Company Product Discount</th>
      <td>{{ $accountsection_2023->company_product_discount }}</td>
    </tr>
    <tr>
      <th>Renewal Discount 2023</th>
      <td>{{ $accountsection_2023->renewal_discount_2023 }}</td>
    </tr>
    <tr>
      <th>Further Discount</th>
      <td>{{ $accountsection_2023->further_discount }}</td>
    </tr>
    <tr>
      <th>Remarks</th>
      <td>{{ $accountsection_2023->remarks }}</td>
    </tr>

    <!-- MARKETING INFORMATION -->

    <tr>
      <th>Source of Inquiry</th>
      <td>{{ $accountsection_2023->source_inquiry }}</td>
    </tr>
    <tr>
      <th>Referral Name</th>
      <td>{{ $accountsection_2023->referral_name }}</td>
    </tr>

    <!-- COMMISSION INFORMATION -->

    <tr>
      <th>Commission Percentage</th>
      <td>{{ $accountsection_2023->percentage_commission }}</td>
    </tr>
    {{-- <tr>
          <th>Commission Received</th>
          <td>{{ $accountsection_2023->commission_received }}</td>
    </tr>
    <tr>
      <th>Commission Received (USD)</th>
      <td>{{ $accountsection_2023->commission_received_in_USD }}</td>
    </tr>
    <tr>
      <th>Commission Received by Bank Account</th>
      <td>{{ $accountsection_2023->bank_account_commission }}</td>
    </tr>
    <tr>
      <th>Commission Status</th>
      <td>{{ $accountsection_2023->confirmation_commission_received }}</td>
    </tr>
    <tr>
      <th>Commission Discount</th>
      <td>{{ $accountsection_2023->commission_discount }}</td>
    </tr> --}}

    <!-- SUBAGENT INFORMATION -->

    <tr>
      <th>Sub-Agent Name</th>
      <td>{{ $accountsection_2023->sub_agents_name }}</td>
    </tr>
    <tr>
      <th>Sub-Agent Percentage Commission</th>
      <td>{{ $accountsection_2023->sub_agent_percentage }}</td>
    </tr>
    <tr>
      <th>Commission Paid to Sub-Agent</th>
      <td>{{ $accountsection_2023->commission_paid }}</td>
    </tr>
    <tr>
      <th>Payment Date to Sub-Agent</th>
      <td>{{ $accountsection_2023->payment_date_subagents_commission }}</td>
    </tr>

    <!-- ENCODER INFORMATION -->

    <tr>
      <th>Encoded By</th>
      <td>{{ $accountsection_2023->encoded_by }}</td>
    </tr>
    <tr>
      <th>Updated By</th>
      <td>{{ $accountsection_2023->updated_by }}</td>
    </tr>

    <tr>
      <th>Status</th>
      <td>{{ $accountsection_2023->status }}</td>
    </tr>
    <tr>
      <th>Missing Remarks</th>
      <td>{{ $accountsection_2023->missing_remarks }}</td>
    </tr>
    <tr>
      <th>Membership Certificate</th>
      <td>@if ($accountsection_2023->attachment)
        <a href="{{  asset('storage/images/' . $accountsection_2023->attachment) }}" class="btn btn-primary" target="_blank">{{$accountsection_2023->attachment}}</a>
        @else
        No Attachment
        @endif
      </td>
    <tr>
      <th>Invoice</th>
      <td>@if ($accountsection_2023->attachment_2)
        <a href="{{  asset('storage/attachment_2/' . $accountsection_2023->attachment_2) }}" class="btn btn-primary" target="_blank">{{$accountsection_2023->attachment_2}}</a>
        @else
        No Attachment
        @endif
      </td>


      <!-- EXTRA -->

      <!-- 
        <tr>
          <th>Website Name</th>endsection
          <td>{{ $accountsection_2023->website }}</td>
        </tr>
        <tr>
          <th>Referral Percentage Commission</th>
          <td>{{ $accountsection_2023->referral_percentage }}</td>
        </tr>
        <tr>
          <th>Net Commission</th>
          <td>{{ $accountsection_2023->net_commission }}</td>
        </tr>
        <tr>
          <th>Estimated Premium</th>
          <td>{{ $accountsection_2023->estimated_premium }}</td>
        </tr>
        <tr>
          <th>Placement Date 2</th>
          <td>{{ $accountsection_2023->placement_date2 }}</td>
        </tr>
        <tr>
          <th>Application E-mail</th>
          <td>{{ $accountsection_2023->application_email }}</td>
        </tr>
        <tr>
          <th>Relationship of Cardholder's to Member</th>
          <td>{{ $accountsection_2023->relationship }}</td>
        </tr>
        <tr>
          <th>Commission 2023</th>
          <td>{{ $accountsection_2023->commission_2023 }}</td>
        </tr>
        <tr>
          <th>Start Date 2023</th>
          <td>{{ $accountsection_2023->start_2023 }}</td>
        </tr>
        <tr>
          <th>Commission Paid to Sub-Agent 2023</th>
          <td>{{ $accountsection_2023->commission_paid_sub_2023 }}</td>
        </tr>
        <tr>      
          <th>Case Officer 2023</th>
          <td>{{ $accountsection_2023->case_officer_2023 }}</td>
        </tr> -->

</div>
</div>