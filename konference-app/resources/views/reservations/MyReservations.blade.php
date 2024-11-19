@extends('layouts.layout')

@section('title', 'My Reservations')

@section('content')
<div class="container">
    <h2>My Reservations</h2>
    @if($reservations->isEmpty())
        <p>You have no reservations.</p>
    @else
        <ul class="list-group">
            @foreach($reservations as $reservation)
                <li class="list-group-item">
                    <strong>Name:</strong> {{ $reservation->name }}<br>
                    <strong>Email:</strong> {{ $reservation->email }}<br>
                    <strong>Phone:</strong> {{ $reservation->phone }}<br>
                    <strong>Conference:</strong> {{ $reservation->conference->name }}<br>
                    <strong>Date:</strong> {{ $reservation->conference->date }}<br>
                    <strong>Location:</strong> {{ $reservation->conference->location }}<br>
                    <strong>Paid:</strong> {{ $reservation->is_paid ? 'Yes' : 'No' }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection