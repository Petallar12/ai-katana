<!DOCTYPE html>
<html>
<head>
    <title>View Claims</title>
</head>
<body>
    <h1>Claims Data</h1>
    @if($data)
        <ul>
            @foreach($data as $claim)
                <li>{{ $claim['claim_id'] }} - {{ $claim['description'] }}</li>
            @endforeach
        </ul>
    @else
        <p>No claims found.</p>
    @endif
</body>
</html>
