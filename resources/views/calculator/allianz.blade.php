@extends('layout')
@section('content')
<!DOCTYPE html>
<head>
<title> BUPA Calculator
 </title>
</head>
<link  rel="stylesheet" href="{{ asset('css/calcu.css') }}">

<body>

    <div class="card">
        <div class="card-header">Allianz Calculator<h4>(Values are updated online)</h4></div>
		
            
				<form action="{{ route('currency') }}"  method="get"  id="quiz-form">


					@csrf
					<label type="float" for="lives">Lives</label><br>
			        <select id="dropdown" name="lives">
			            <option value="0.15">New Lives</option>
                        <option value="0.15">Existing</option>                                                                      
                    </select><br>
					
					{{-- Value of Lives
					<input class="lblDisplay" name="lives" class="lblDisplay" type="float" value="{{$lives}}" disabled>
					
					<br> 
					<br> --}}

					<label for="currency">Currency</label><br>
					<select id="dropdown" name="currency_from" required>
						<option value="">Select Currency</option>
						<option value="SGD" {{ Request::get('currency_from') == 'SGD'?'selected':'' }}>SGD</option>
						<option value="EUR" {{ Request::get('currency_from') == 'EUR'?'selected':'' }}>Euro</option>
						<option value="GBP" {{ Request::get('currency_from') == 'GBP'?'selected':'' }}>GBP</option>
						<option value="IDR" {{ Request::get('currency_from') == 'IDR'?'selected':'' }}>IDR</option>
						<option value="VND" {{ Request::get('currency_from') == 'VND'?'selected':'' }}>VND</option>
                        <option value="USD" {{ Request::get('currency_from') == 'USD'?'selected':'' }}>USD</option>
						
					</select>
					<br>
					
						<label for="SecondNumber">Payment Frequency</label><br>
							<select id="dropdown" name="SecondNumber">
								<option value="1">Annually</option>
								<option value="4">Quarterly</option>
								<option value="2">Semi-Annually</option>     
								<option value="12">Monthly</option>     
								<option value=""></option>
							</select><br>
					<br>
					<label>Enter premium</label>
					<br>
					<input class="lblDisplay" type="float" name="amount" id="amount" value="{{Request::get('amount')}}" required>
					<br><br>
					<label>Active Premium</label><br>
					<input class="lblDisplay" readonly="readonly" name="active_premium" id="active_premium" value="{{ $active_premium ?? ''  }}">
					<br><br>
					<label>Frequency Premium</label><br>
					<input class="lblDisplay" readonly="readonly" name="frequency_premium" id="frequency_premium" value="{{ $frequency_premium ?? ''  }}">
					<br><br>
				

					<label>Convert to USD</label><br>					
					<input class="lblDisplay" name="convert_USD" class="lblDisplay" type="float" value="{{$converted}}" disabled>
					<br><br>
					{{-- <label>Total Commission</label><br>
					<input class="lblDisplay" readonly="readonly" name="total_commission" value="{{ $total_commission ?? ''  }}">
					<br><br> --}}
					<button type="submit" class="col-3 btn btn-primary">Submit</button>
					<br>

					
				</form>
      
  </body>
</html>

@endsection
{{-- <body>

<div class="card">
	<div class="card-header">Allianz Calculator</div>
		<form action="/calculator/allianz" method="post" id="quiz-form">
		@csrf

			<form action="/calculator/allianz" method="POST">
			    <label for="lives">Lives</label><br>
			        <select id="dropdown" name="lives">
			            <option value="0.15">New Lives</option>
                        <option value="0.15">Existing</option>                                                                      
                    </select><br>

			<form action="/calculator/allianz" method="POST">
			    <label for="currency">Currency</label><br>
			        <select id="dropdown" name="currency">
				        <option value="1.25">GBP</option>
                        <option value="1.06">EURO</option> 
                        <option value="0.72">SGD</option>     
                        <option value="0.00007">IDR</option>     
                        <option value="0.00004">VND</option>   
                        <option value=""></option>
					</select><br>

			<form action="/calculator/allianz" method="POST">
			    <label for="SecondNumber">Payment Frequency</label><br>
			        <select id="dropdown" name="SecondNumber">
			            <option value="1">Annually</option>
                        <option value="4">Quarterly</option>
                        <option value="2">Semi-Annually</option>     
                        <option value="12">Monthly</option>     
                        <option value=""></option>
					</select><br>
                        
            <label>Enter Premium</label><br>
				<input type="float" name="FirstNumber" id="FirstNumber" required="required" value="{{ $first_number ?? '' }}"> 
			<br>

			<label>Active Premium</label><br>
				<input class="lblDisplay" readonly="readonly" name="active_premium" id="active_premium" value="{{ $active_premium ?? ''  }}">
			<br>

			<label>Frequency Premium</label><br>
				<input class="lblDisplay" readonly="readonly" name="frequency_premium" id="frequency_premium" value="{{ $frequency_premium ?? ''  }}">
			<br>

			<label>Convert to USD</label><br>
				<input class="lblDisplay" readonly="readonly" name="convert_usd" value="{{ $convert_usd ?? ''  }}">
			<br>

			<label>Total Commission</label><br>
				<input class="lblDisplay" readonly="readonly" name="total_commission" value="{{ $total_commission ?? ''  }}">
			<br>
			
			<br>
			<input class="btnCompute" type="submit" name="operator" value="Calculate"></input>
		</form>
	</div>
</body>
</html>

@endsection --}}