<h1>Reservation Confirmed</h1>

<p>Hi {{ $reservation->user->name }},</p>

<p>Your reservation for <strong>{{ $reservation->room->name }}</strong> at <strong>{{ $reservation->room->hotel->name }}</strong> is confirmed.</p>

<p>
<strong>Check-in:</strong> {{ $reservation->check_in }}<br>
<strong>Check-out:</strong> {{ $reservation->check_out }}<br>
<strong>Total Price:</strong> {{ $reservation->total_price }} DH
</p>

<p>Thanks,<br>HotelApp</p>