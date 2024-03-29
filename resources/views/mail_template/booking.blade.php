<!DOCTYPE html>
<html>
<head>
    <title>Laravel Send Email Example</title>
</head>
<body>

<h1>This is test mail from Booking form</h1>
<br>
===========================================
<h4>Booking information</h4>
<br>
<b>Check in :</b> <p>{{ $start }}</p>
<br>
<b>Check out :</b> <p>{{ $end }}</p>
<br>
<b>Adults :</b> <p>{{ $adults }}</p>
<br>
<b>Children :</b> <p>{{ $children }}</p>
<br>
@if(isset($ages) && !empty($ages))
    @php
        $ageText = '';
        foreach ($ages as $key => $value) {
            if ($key < count($ages) - 1) {
                 $ageText .= $value.', ';
            }else{
                $ageText .= $value;
            }
        }
    @endphp
    <b>Children age : {{ $ageText }}</b>
    <br>
    <br>
@endif
===========================================
</body>
</html>
