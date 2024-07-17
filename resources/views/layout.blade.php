<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dataloki</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom Google Fonts CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/google-fonts.css') }}"/>
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />

    <!-- Bootstrap v5.2.2 CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
 
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light fixed-top">
        <div class="container">
            <a href="{{ url('/') }}"><img src="/assets/images/dt-white.png" alt="Datalokey Logo" class="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <!-- <ul class="navbar-nav me-auto"></ul> -->

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @else


                    <!-- DASHBOARDS -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-square-poll-vertical fa-icon"></i>
                                Dashboards
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/dashboard">IPMI 2022</a></li>
                                <li><a class="dropdown-item" href="/2023/dashboard">IPMI 2023</a></li>
                                <li><a class="dropdown-item" href="/2024/dashboard">IPMI 2024</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- CLIENTS -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-group fa-icon"></i>
                                Clients
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/accountsection/index">Database 2022</a></li>
                                <li><a class="dropdown-item" href="/2023/accountsection/index">Database 2023</a></li>
                                <li><a class="dropdown-item" href="/2024/accountsection/index">Database 2024</a></li>
                            </ul>
                        </div>
                    </li>


                    <!-- REMINDER -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-bell fa-icon"></i>
                                Reminders
                            </button>
                            <ul class="dropdown-menu">
                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management')     
                                <li><a class="dropdown-item" href="/2023/notification/renewals_per_month">Renewals</a></li>
                                @endif
                                <li><a class="dropdown-item" href="/2023/notification/birthday">Birthdays</a></li>
                            </ul>
                        </div>
                    </li>


                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')     
                    <!-- RECORD -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-file-medical fa-icon"></i>
                                Add Record
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/accountsection/create">Record 2022</a></li>
                                <li><a class="dropdown-item" href="/2023/accountsection/create">Record 2023</a></li>
                                <li><a class="dropdown-item" href="/2024/accountsection/create">Record 2024</a></li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder'|| auth()->user()->role == 'Management')     
                    <!-- DAILY HEADCOUNT -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-file-contract fa-icon"></i>
                                Daily Headcount
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/databasis/cancellation_newlives">Daily Headcount 2022</a></li>
                                <li><a class="dropdown-item" href="/2023/databasis/cancellation_newlives">Daily Headcount 2023</a></li>
                                <li><a class="dropdown-item" href="/2024/databasis/cancellation_newlives">Daily Headcount 2024</a></li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')     
                    <!-- PREMIUM CALCULATOR -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-calculator fa-icon"></i>
                                Calculator
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/calculator/bupa">Bupa Calculator</a></li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    <!-- PROFILE -->
                    <li class="nav-item dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-circle-user fa-icon"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->role == 'IT admin')
                                <a class="dropdown-item" href="/registration">Register An Account</a>
                                @endif
                                <!-- <a class="dropdown-item" href="/privacy">Data Privacy Notice</a> -->
                                <a class="dropdown-item" href="/auth/forgot_password">Change Password</a>
                                @if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')     
                                <a class="dropdown-item" href="/2023/dashboard/compare_2022_2023">Lives Status 2022-2023</a>
                                <a class="dropdown-item" href="https://docs.google.com/spreadsheets/d/1o_sY_pkYrPBNDhsxKkhzADMKyE3jW4ItlMztuuQtfXk/edit#gid=0" target="_blank">Placement 2022</a>
                                <a class="dropdown-item" href="https://docs.google.com/spreadsheets/d/1_zNyxU__7esTYBPz1RxUnt_I-eBhfFi14JplX6AsWFk/edit#gid=0" target="_blank">Placement 2023</a>
                                <a class="dropdown-item" href="https://briconus.sharepoint.com/:f:/s/Repository/El2fK_Cn7IBMo92Vb-ASeCcBNuqQYknikN8JwB8ys2CZkA?e=nE6tSF" target="_blank">Renewal 2023</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
      <div class="custom-container">
        @yield('content')
      </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
