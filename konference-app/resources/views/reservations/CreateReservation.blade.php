@extends('layouts.layout')

@section('title', 'Create Reservation')

@section('content')

<div class="container">
    <h2>Create Reservation</h2>
    <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="conference_id">Conference</label>
                <select class="form-control" id="conference_id" name="conference_id" required>
                    @foreach($conferences as $conference)
                        <option value="{{ $conference->id }}">{{ $conference->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>
@endsection
