<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

    <!-- Custom Google Fonts CSS -->
        <link
            rel="stylesheet"
            href="{{ asset('assets/fonts/google-fonts.css') }}"
        />

    @if (session('error'))
        <meta name="error-message" content="{{ session('error') }}">
    @endif
    
</head>
<body class="body">
    <div class="box">
        <div class="container">
            <div>
                <img src="/assets/images/dt-purple.png" alt="Datalokey Logo" class="logo" />
            </div>
            <form method="POST" action="{{ route('login') }}" onsubmit="return validateForm()" novalidate>
                @csrf
                <div class="input-field">
                    <input type="email" id="email" class="input" name="email" 
                           autocomplete="email" autofocus placeholder="Please enter username" />
                    <i class="fa-solid fa-user icon"></i>
                </div>

                <div class="input-field">
                    <input id="password" type="password" class="input" name="password" 
                           autocomplete="current-password" placeholder="Please enter password" />
                    <i class="fa-solid fa-key icon"></i>
                    <i class="fas fa-eye show-password" onclick="togglePasswordVisibility()"></i>
                </div>

                <div class="input-field">
                    <input type="submit" class="submit" value="Login" />
                </div>

                <div class="login-setting">
                    <div class="remember">
                        <input type="checkbox" id="rememberMe" />
                        <label for="rememberMe">Remember me</label>
                    </div>
                    <div class="forgot">
                        <label><a href="/auth/forgot_password/">Forgot password?</a></label>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
