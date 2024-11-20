@extends('layouts.layout')

@section('title', 'Manage Reservations')

@section('content')
<div class="container">
    <h2>Manage Reservations for Conference: {{ $conference->name }}</h2>

    <div class="mb-4">
        <a href="{{ route('reservations.create', ['conference_id' => $conference->id]) }}" class="btn btn-primary">Add Reservation</a>
        <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary me-2">Details</a>
    </div>

    @if($reservations->isEmpty())
        <div class="alert alert-info">
            No reservations found for this conference.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Paid Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <th scope="row">{{ $reservation->name }}</th>
                        <td>{{ $reservation->email }}</td>
                        <td>{{ $reservation->phone }}</td>
                        <td>
                            @if($reservation->is_paid)
                                <span class="badge badge-success">Paid</span>
                            @else
                                <span class="badge badge-danger">Not paid</span>
                            @endif
                        </td>
                        <td>
                            @if(!$reservation->is_paid)
                                <form action="{{ route('reservations.confirm', $reservation->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                </form>
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
