@extends('layout')
@section('content')


@section('content')
<div class="container">
    <h1>Claims Data</h1>
    @if(isset($data) && is_array($data))
        <ul>
            @foreach($data as $claim)
            <li>{{ $claim['claim_number'] ?? 'No Claim Number' }} - {{ $claim['total_amount'] ?? 'No Amount' }}</li>
        @endforeach
        </ul>
    @else
        <p>No claims found or there was an error in fetching data.</p>
    @endif
</div>
@endsection
