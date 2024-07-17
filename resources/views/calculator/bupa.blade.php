@extends('layout')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUPA Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/calcu.css') }}">
</head>
<body>

@if(auth()->user()->role == 'IT admin' || auth()->user()->role == 'Encoder')
    <div class="card">
        <div class="card-header">BUPA Calculator</div>
        <form action="/calculator/compute" method="post" id="quiz-form">
            @csrf

            <label for="lives">Lives</label><br>
            <select id="dropdown" name="lives">
                <option value="0.15">New Lives</option>
                <option value="0.10">Existing</option>                                                                      
            </select><br>

            <label for="currency">Currency</label><br>
            <select id="dropdown" name="currency">
                <option value="1.27">GBP</option>
                <option value="1.08">EURO</option> 
                <option value="0.74">SGD</option>     
                <option value="0.000066">IDR</option>     
                <option value="0.000042">VND</option>   
                <option value="0.272">AED</option>   
                <option value="0.018">PHP</option>   
                <option value=""></option>
            </select><br>

            <label for="SecondNumber">Payment Frequency</label><br>
            <select id="dropdown" name="SecondNumber">
                <option value="1">Annually</option>
                <option value="4">Quarterly</option>
                <option value="2">Semi-Annually</option>     
                <option value="12">Monthly</option>     
                <option value=""></option>
            </select><br>

            <label>Enter Premium</label><br>
            <input class="lblDisplay" type="float" name="FirstNumber" id="FirstNumber" required value="{{ $first_number ?? '' }}"> 
            <br>

            <label>Active Premium</label><br>
            <input class="lblDisplay" readonly="readonly" name="active_premium" id="active_premium" value="{{ $active_premium ?? '' }}">
            <br>

            <label>Frequency Premium</label><br>
            <input class="lblDisplay" readonly="readonly" name="frequency_premium" id="frequency_premium" value="{{ $frequency_premium ?? '' }}">
            <br>

            <label>Convert to USD</label><br>
            <input class="lblDisplay" readonly="readonly" name="convert_usd" value="{{ $convert_usd ?? '' }}">
            <br>

            <label>Total Commission</label><br>
            <input class="lblDisplay" readonly="readonly" name="total_commission" value="{{ $total_commission ?? '' }}">
            <br>

            <input class="btnCompute" type="submit" name="operator" value="Calculate">
        </form>
    </div>
@else
    <script>
        window.location.href = "/login";
    </script>
@endif

</body>
</html>
@endsection
