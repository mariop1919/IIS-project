@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Edit Presentation: {{ $presentation->title }}</h1>

        <!-- Error message for validation errors -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Form for editing presentation -->
        <form action="{{ route('presentations.update', $presentation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Room selection -->
            <div class="mb-3">
                <label for="room_id" class="form-label">Room <span class="text-danger">*</span></label>
                <select name="room_id" id="room_id" class="form-control" required>
                    <option value="" disabled>Select a room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" 
                                {{ old('room_id', $presentation->room_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                       value="{{ old('start_time', $presentation->start_time) }}" required>
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                       value="{{ old('end_time', $presentation->end_time) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('presentations.manage', $presentation->conference_id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
