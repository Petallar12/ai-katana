@extends('layout')
@section('content')

<!-- FOR CARD DISPLAY BASED ON LOGGED ROLE -->
<script>
    var userRole = @json(auth()->user()->role);
</script>

<!-- DASHBOARD 2022 -->
<!-- HEADER -->
<div class="header">
    <h2 class="title-header">IPMI DASHBOARD 2022</h2>
    <p class="title-header-text">Total Number of Clients as of 2022:</p>
    <div class="total-clients-div">
        <p class="total-clients">{{ number_format($clients) }}</p>
    </div>
</div>

<div class="dashboard-container">
    <!-- DISPLAY CARD FOR NEW LIVES -->
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">New Lives 2022</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" id="new-lives-prev-btn"><</button>
                    <button type="button" class="btn btn-light btn-sm" id="new-lives-next-btn">></button>
                </div>
            </div>
            <div class="card-body">
                <div id="new-lives-div">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($newlives) }}</strong></li>
                        <li>Total New Lives</li>
                    </ul>
                </div>
                <div id="new-lives-active-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($newlives_active) }}</strong></li>
                        <li>Number of Active</li>
                    </ul>
                </div>
                <div id="new-lives-pended-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($pended) }}</strong></li>
                        <li>Number of Pending</li>
                    </ul>
                </div>
                <div id="new-lives-addon-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($newlives_active_addon) }}</strong></li>
                        <li>New Lives Add-on</li>
                    </ul>
                </div>
                <div id="new-lives-lapsed-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($lapsed_newlives) }}</strong></li>
                        <li>Lapsed New Lives</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR RENEWALS -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Renewals 2022</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" id="renewals-prev-btn"><</button>
                    <button type="button" class="btn btn-light btn-sm" id="renewals-next-btn">></button>
                </div>
            </div>
            <div class="card-body">
                <div id="renewals-div">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($renewals) }}</strong></li>
                        <li>Total Renewals</li>
                    </ul>
                </div>
                <div id="renewals-active-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($renewals_Active) }}</strong></li>
                        <li>Number of Active</li>
                    </ul>
                </div>
                <div id="renewals-lapsed-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($renewals_Lapsed) }}</strong></li>
                        <li>Lapsed After 6 Months</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR CANCELLATION -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Cancellation 2022</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" id="cancel-prev-btn"><</button>
                    <button type="button" class="btn btn-light btn-sm" id="cancel-next-btn">></button>
                </div>
            </div>
            <div class="card-body">
                <div id="cancel-div">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($cancelled) }}</strong></li>
                        <li>Total Cancellation</li>
                    </ul>
                </div>
                <div id="cancel-year-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($cancelled_2022) }}</strong></li>
                        <li>Cancellation 2022</li>
                    </ul>
                </div>
                <div id="cancel-year2-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($cancelled_2021) }}</strong></li>
                        <li>2021 and below</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR ACTIVE CLIENTS -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Total Active Clients</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                    <li><strong>{{ number_format($total_members) }}</strong></li>
                    <li>Total Active</li>
                </ul>
            </div>
        </div>

        <!-- DISPLAY CARD FOR CANCELLATION BUFFER -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Cancellation Buffer</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                    <li><strong>{{ number_format($total) }}</strong></li>
                    <li>Cancellation - New Lives</li>
                </ul>
            </div>
        </div>

        <!-- DISPLAY CARD FOR TOTAL PREMIUM -->
        @if(auth()->user()->role == '1' || auth()->user()->role == '2'|| auth()->user()->role == '3')
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Premium</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="premium-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="premium-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="premium-usd-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li><strong>${{$formattedPremium}}</strong></li>
                        <li>Premium in USD</li>
                    </ul>
                </div>
                <div id="premium-sgd-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li><strong>N/A</strong></li>
                        <li>Premium in SGD</li>
                    </ul>
                </div>
            </div>
        </div>
      

        <!-- DISPLAY CARD FOR COMMISSION -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Commission</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="commission-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="commission-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="commission-usd-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                       
                        <li><strong>${{$formattedCommission}}</strong></li>
                         <li>Commission in USD</li>
                    </ul>
                </div>
                <div id="commission-sgd-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                      
                        <li><strong>N/A</strong></li>
                          <li>Commission in SGD:</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif



        <!-- DISPLAY CARD FOR GROUP COUNT -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Individual and Group Count</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" id="group-prev-btn"><</button>
                    <button type="button" class="btn btn-light btn-sm" id="group-next-btn">></button>
                </div>
            </div>
            <div class="card-body">
                <div id="group-div">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($individual) }}</strong></li>
                        <li>Total Active Individuals</li>
                    </ul>
                </div>
                <div id="group-active-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($clients_group_count) }}</strong></li>
                        <li>Total Active Under Group</li>
                    </ul>
                </div>
                <div id="group-lapsed-div" style="display: none">
                    <ul class="list-unstyled mt-3 align-items-center justify-content-between">
                        <li><strong>{{ number_format($group_count) }}</strong></li>
                        <li>Total Groups</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAPHS -->
    @if(auth()->user()->role == '1' || auth()->user()->role == '2'|| auth()->user()->role == '3')
    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Total Premium and Commission Up To Date</h3>
            <a href="/dashboard/premium_commission" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="premium_commission_iframe" src="/dashboard/premium_commission" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>
    @endif

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Monthly Count of New Lives and Renewals</h3>
            <a href="/dashboard/lives_2022" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="lives_2022_iframe" src="/dashboard/lives_2022" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Source of Inquiry 2022</h3>
            <a href="/dashboard/source_inquiry" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="source_inquiry_iframe" src="/dashboard/source_inquiry" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Number of Policy per Insurer 2022</h3>
            <a href="/dashboard/insurer" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="insurer_iframe" src="/dashboard/insurer" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Number of Policy per Country 2022</h3>
            <a href="/dashboard/country" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="country_iframe" src="/dashboard/country" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Number of Policy per Main Applicant's Age 2022</h3>
            <a href="/dashboard/age" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="age_iframe" src="/dashboard/age" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    @if(auth()->user()->role == '1' || auth()->user()->role == '2'|| auth()->user()->role == '3')
    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Total Premium per Country</h3>
            <a href="/dashboard/country_premium" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="country_premium_iframe" src="/dashboard/country_premium" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>
    @endif

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Case Closed Count - New Lives 2022</h3>
            <a href="/databasis/monthly_newlives" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="monthly_newlives_iframe" src="/databasis/monthly_newlives" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>

    <div class="graph-card">
        <div class="graph-card-header">
            <h3>Case Closed Count - Renewals 2022</h3>
            <a href="/databasis/monthly_renewals" target="_blank">
                <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
            </a>
        </div>
        <div class="graph-card-footer">
            <iframe id="monthly_renewals_iframe" src="/databasis/monthly_renewals" frameborder="0" class="auto-height"></iframe>
        </div>
    </div>
</div>

<!-- SCRIPT FOR DASHBOARD -->
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection