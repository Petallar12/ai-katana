@extends('layout')
<br><br>
<style>
    body{
        color:white;
    }
    label{
        color:white;
    }
</style>    
@section('content')
<div class="card" style = "background: rgb(62, 131, 219);
background: linear-gradient(90deg, rgba(62, 131, 219, 1) 0%, rgba(6, 63, 184, 1) 100%); box-sizing:border-box; max-width: 40%; margin: 20px auto; border-radius: 50px; text-align: center; font-weight: bold;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            
            <div class="card-header" style="font-size: 30px; margin-top: 10px; color: white; background-color: rgba(111, 107, 107, 0); border-radius: 50px;">{{ __('Forgot Password') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('updatePassword') }}">

                        @csrf

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Your Email Address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Your New Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Re-Enter Your New Password">
                            </div>
                        </div>

                        {{-- Code --}}
                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('OTP Code') }}</label>
                        
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" maxlength="6" required autocomplete="code" placeholder="Type Code">
                                    {{-- <div class="input-group-append"> --}}
                                        <button type="button" class="btn btn-primary" id="sendCodeButton" style="display: none;">
                                            {{ __('Send Code') }}
                                        </button>
                                    {{-- </div> --}}
                                </div>
                        
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button style=" border-radius: 50px;"type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add a click trigger to the "Send Code" button
    document.getElementById('sendCodeButton').addEventListener('click', function () {
        // Get the email value (if needed)
        var email = document.getElementById('email').value;

        // Define the route name (if needed)
        var routeName = 'store'; // Replace with the actual route name

        // Construct the URL for the route
        var routeUrl = "{{ route('storecode') }}"; // Use double curly braces for Laravel variable substitution

        // Create an object with the data you want to send (e.g., email)
        var requestData = {
            email: email, // Replace 'email' with your parameter name
            _token: "{{ csrf_token() }}" // Include the CSRF token in the request
        };

        // Make an AJAX POST request to the route
        fetch(routeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': requestData._token // Include the CSRF token in the headers
                // You can add more headers if needed
            },
            body: JSON.stringify(requestData), // Convert the data to JSON
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data here
            console.log(data);
    //add A notif Box        
            Swal.fire({
  title: "Email Has Been Sent!",
  text: "Please Check Your Email Account!",
  icon: "success"
});
            // You can perform actions based on the response
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors here
        });
    });

    // Add an event listener to the email input to toggle the button
    document.getElementById('email').addEventListener('input', function () {
        if (this.value.trim() !== '') {
            document.getElementById('sendCodeButton').style.display = 'block';
        } else {
            document.getElementById('sendCodeButton').style.display = 'none';
        }
    });
</script>

@endsection
