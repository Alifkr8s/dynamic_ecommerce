<!DOCTYPE html>
<html lang="en">

<head>
<title>Deal Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow-lg">

<div class="card-header bg-primary text-white">
<h2>Group Buy Deal: {{ $deal->product_name }}</h2>
</div>

<div class="card-body text-center">

{{-- PARTICIPANTS --}}
<h4 class="text-secondary">
Participants Joined:
<span class="badge bg-info">
{{ $participants }}
</span>
</h4>

{{-- DYNAMIC PRICE --}}
@php
$price = $deal->base_price;

if($participants >= 5) $price = $price - 200;
elseif($participants >= 3) $price = $price - 100;
@endphp

<h3 class="mt-3">
Price:
<span class="text-success">
${{ $price }}
</span>
</h3>

<hr>

{{-- TIMER --}}
<div class="py-3">
<h5>Deal Ends In:</h5>

<div id="timer" class="display-5 text-danger fw-bold">
00:00:00
</div>
</div>

@php
$expired = now()->greaterThan($deal->end_time);
@endphp

{{-- AUTH SECTION --}}
@auth

@if($expired)

<div class="alert alert-danger">
Deal Expired! You can no longer join or pay.
</div>

@else

{{-- JOIN --}}
<form method="POST" action="/deal/join">
@csrf
<input type="hidden" name="user_id" value="{{ auth()->id() }}">
<input type="hidden" name="deal_id" value="{{ $deal->id }}">

<button class="btn btn-success btn-lg mt-3">
Join Deal
</button>
</form>

{{-- PAYMENT --}}
<form method="POST" action="/payment/request" class="mt-3">
@csrf
<input type="hidden" name="user_id" value="{{ auth()->id() }}">
<input type="hidden" name="deal_id" value="{{ $deal->id }}">
<input type="hidden" name="amount" value="{{ $price }}">
<input type="hidden" name="payment_method" value="bkash">

<button class="btn btn-warning btn-lg">
Pay Now
</button>
</form>

@endif

@else

<p class="text-muted mt-3">
Please login to join this deal
</p>

<a href="{{ route('login') }}" class="btn btn-primary">Login</a>
<a href="{{ route('register') }}" class="btn btn-warning">Register</a>

@endauth

{{-- SUCCESS MESSAGE --}}
@if(session('status'))
<div class="alert alert-success mt-3">
{{ session('status') }}
</div>
@endif

</div>
</div>
</div>

{{-- TIMER SCRIPT --}}
<script>

const endTime = new Date("{{ $deal->end_time }}").getTime();
const timer = document.getElementById("timer");

setInterval(function(){

let now = new Date().getTime();
let distance = endTime - now;

if(distance < 0){
timer.innerHTML = "EXPIRED";
return;
}

let hrs = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
let mins = Math.floor((distance % (1000*60*60)) / (1000*60));
let secs = Math.floor((distance % (1000*60)) / 1000);

timer.innerHTML =
hrs.toString().padStart(2,'0') + ":" +
mins.toString().padStart(2,'0') + ":" +
secs.toString().padStart(2,'0');

},1000);

</script>

</body>
</html>