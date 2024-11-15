@extends('layouts.layout')

@section('title', 'Add Room to Conference')

@section('content')
<div class="container">
    <h1>Add Room to {{ $conference->name }}</h1>
    <form action="{{ route('conference_rooms.store', $conference) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="room_id">Select Room</label>
            <select class="form-control" id="room_id" name="room_id">
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Room</button>
    </form>
</div>
@endsection