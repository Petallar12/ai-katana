@extends('layout') @section('content')

<!-- FOR CARD DISPLAY BASED ON LOGGED ROLE -->
<script>
    var userRole = @json(auth()->user()->role);
</script>

<!-- DASHBOARD 2023 -->
@if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management'|| auth()->user()->role == 'Case Officer')     

<div class="header">
    <h2 class="title-header">IPMI DASHBOARD 2024</h2>
    <p class="title-header-text">Total Number of Clients as of today:</p>
    <div class="total-clients-div">
        <p class="total-clients">{{ number_format($clients) }}</p>
    </div>
</div>
@endif
<div class="dashboard-container">
    <!-- DISPLAY CARD FOR NEW LIVES -->
    <div class="dashboard-cards">
        <!-- DISPLAY CARD FOR NEW LIVES -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">New Lives</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="new-lives-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="new-lives-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="new-lives-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        <li><strong>{{ number_format($newlives) }}</strong></li>
                        <li>Total New Lives</li>
                    </ul>
                </div>
                <div id="new-lives-active-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        <li>
                            <strong
                                >{{ number_format($newlives_active) }}</strong
                                
                            >
                        </li>
                        <li>Number of Active</li>
                    </ul>
                </div>
                <div id="new-lives-pended-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        <li><strong>{{ number_format($pended) }}</strong></li>
                        <li>Number of Pending</li>
                    </ul>
                </div>
                <div id="new-lives-addon-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li>
                            <strong
                                >{{ number_format($newlives_active_addon)
                                }}</strong
                            >
                        </li>
                        <li>New Lives Add-on</li>
                    </ul>
                </div>
                <div id="new-lives-lapsed-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li>
                            <strong
                                >{{ number_format($lapsed_newlives) }}</strong
                            >
                        </li>
                        <li>Lapsed New Lives</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR RENEWALS -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Renewals</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="renewals-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="renewals-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="renewals-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li><strong>{{ number_format($renewals) }}</strong></li>
                        <li>Total Renewals</li>
                    </ul>
                </div>
                <div id="renewals-active-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                    
                        <li>
                            <strong
                                >{{ number_format($renewals_Active) }}</strong
                            >
                        </li>
                            <li>Number of Active</li>
                    </ul>
                </div>
                <div id="renewals-lapsed-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li>
                            <strong
                                >{{ number_format($renewals_Lapsed) }}</strong
                            >
                        </li>
                        <li>Lapsed After 6 Months</li>
                    </ul>
                </div>
                <div id="renewal-addon-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                       
                        <li>
                            <strong
                                >{{ number_format($renewal_newlives) }}</strong
                            >
                        </li>
                         <li>Renewals Add-on</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR CANCELLATION -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Cancellation</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="cancel-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="cancel-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="cancel-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                      
                        <li>
                            <strong>{{ number_format($cancelled) }}</strong>
                        </li>
                          <li>Total Cancellation</li>
                    </ul>
                </div>
                <div id="cancel-year-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                    
                        <li>
                            <strong
                                >{{ number_format($cancelled_newlives)
                                }}</strong
                            >
                        </li>
                            <li>New Lives Cancellation</li>
                    </ul>
                </div>
                <div id="cancel-year2-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                      
                        <li>
                            <strong
                                >{{ number_format($cancelled_renewal) }}</strong
                            >
                        </li>
                          <li>Renewals Cancellation</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR ACTIVE CLIENTS -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Total Active Clients</h5>
            </div>
            <div class="card-body">
                <ul
                    class="list-unstyled mt-3 align-items-center justify-content-between"
                >
                   
                    <li>
                        <strong>{{ number_format($total_members) }}</strong>
                    </li>
                     <li>Total Active</li>
                </ul>
            </div>
        </div>

        <!-- DISPLAY CARD FOR CANCELLATION BUFFER -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Cancellation Buffer</h5>
            </div>
            <div class="card-body">
                <ul
                    class="list-unstyled mt-3 align-items-center justify-content-between"
                >
                 
                    <li><strong>{{ number_format($total) }}</strong></li>
                       <li>Cancellation - New Lives</li>
                </ul>
            </div>
        </div>

        <!-- DISPLAY CARD FOR GROUP COUNT -->
        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <h5 class="card-title mb-0">Individual and Group Count</h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="group-prev-btn"
                    >
                        <
                    </button>
                    <button
                        type="button"
                        class="btn btn-light btn-sm"
                        id="group-next-btn"
                    >
                        >
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="group-div">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                       
                        <li>
                            <strong>{{ number_format($individual) }}</strong>
                        </li>
                         <li>Total Active Individuals</li>
                    </ul>
                </div>
                <div id="group-active-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                        
                        <li>
                            <strong
                                >{{ number_format($clients_group_count)
                                }}</strong
                            >
                        </li>
                        <li>Total Active Under Group</li>
                    </ul>
                </div>
                <div id="group-lapsed-div" style="display: none">
                    <ul
                        class="list-unstyled mt-3 align-items-center justify-content-between"
                    >
                       
                        <li>
                            <strong>{{ number_format($group_count) }}</strong>
                        </li>
                         <li>Total Groups</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- DISPLAY CARD FOR PREMIUM -->
        @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management')     
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
                        
                        <li><strong>${{$formattedPremiumSGD}}</strong></li>
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
                      
                        <li><strong>${{$formattedCommissionSGD}}</strong></li>
                          <li>Commission in SGD:</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

   <!-- GRAPHS -->
   @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management')     

<!-- DISPLAY CARD FOR PREMIUM & COMMISSION -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Monthly Total of Premium and Commission</h3>
        <a href="/2024/dashboard/premium_commission" target="_blank">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="premium_commission_iframe"
            src="/2024/dashboard/premium_commission"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>
@endif

<!-- NEW LIVES AND RENEWALS -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Monthly Count of New Lives and Renewals</h3>
        <a href="/2024/dashboard/lives_2024">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="lives_2024_iframe"
            src="/2024/dashboard/lives_2024"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- SOURCE OF INQUIRY -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Source of Inquiry for New Lives</h3>
        <a href="/2024/dashboard/source_inquiry">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="source_inquiry_iframe"
            src="/2024/dashboard/source_inquiry"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- TOTAL POLICY PER INSURER -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Number of Active Policy per Insurer</h3>
        <a href="/2024/dashboard/insurer">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="insurer_iframe"
            src="/2024/dashboard/insurer"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- TOTAL POLICY PER COUNTRY -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Number of Active Policy per Country</h3>
        <a href="/2024/dashboard/country">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="country_iframe"
            src="/2024/dashboard/country"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- TOTAL POLICY PER AGE -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Number of Policy per Main Applicant's Age</h3>
        <a href="/2024/dashboard/age">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="age_iframe"
            src="/2024/dashboard/age"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

@if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management')     

<!-- PREMIUM PER COUNTRY -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Total Premium per Country</h3>
        <a href="/2024/dashboard/country_premium">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="country_premium_iframe"
            src="/2024/dashboard/country_premium"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- TOTAL PREMIUM & COMMISSION PER INSURER -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Premium and Commission per Insurer</h3>
        <a href="/2024/dashboard/insurer_premium">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="insurer_premium_iframe"
            src="/2024/dashboard/insurer_premium"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>
@endif

<!-- MONTHLY NEW LIVES 2024 -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Case Closed Count for New Lives</h3>
        <a href="/2024/databasis/monthly_newlives">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="monthly_newlives_iframe"
            src="{{ url('/2024/databasis/monthly_newlives') }}"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

<!-- MONTHLY RENEWALS 2024 -->
<div class="graph-card">
    <div class="graph-card-header">
        <h3>Case Closed Count for Renewals</h3>
        <a href="/2024/databasis/monthly_renewals">
            <i class="bx bx-fullscreen bx-burst-hover bx-sm"></i>
        </a>
    </div>
    <div class="graph-card-footer">
        <iframe
            id="monthly_renewals_iframe"
            src="{{ url('/2024/databasis/monthly_renewals') }}"
            frameborder="0"
            class="auto-height"
        ></iframe>
    </div>
</div>

</div>

<!-- SCRIPT FOR DASHBOARD -->
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection
