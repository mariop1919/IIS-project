@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Edit Presentation: {{ $presentation->title }}</h1>

        <form action="{{ route('presentations.update', $presentation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-control" required>
                    <option value="" disabled>Select a room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $presentation->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                       value="{{ $presentation->start_time }}" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                       value="{{ $presentation->end_time }}" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('presentations.manage', $presentation->conference_id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
