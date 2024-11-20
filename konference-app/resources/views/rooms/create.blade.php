@extends('layouts.layout')

@section('title', 'Add Room to Conference')

@section('content')
<div class="container">
    <h1>Add Room to Conference</h1>
    <form action="{{ route('conference_rooms.store') }}" method="POST">
        @csrf

        <!-- Select Conference -->
        <div class="form-group">
            <label for="conference_id">Select Conference <span class="text-danger">*</span></label>
            <select class="form-control" id="conference_id" name="conference_id" required>
                <option value="" disabled {{ old('conference_id') ? '' : 'selected' }}>Select a conference</option>
                @foreach ($conferences as $conference)
                    <option value="{{ $conference->id }}" {{ old('conference_id') == $conference->id ? 'selected' : '' }}>{{ $conference->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Room Name -->
        <div class="form-group">
            <label for="room_name">Room Name <span class="text-danger">*</span></label>
            <input type="text" name="room_name" id="room_name" class="form-control" placeholder="Enter room name" value="{{ old('room_name') }}" required>
        </div>

        <!-- Equipment -->
        <div class="form-group">
            <label for="equipment">Equipment</label>
            <input type="text" name="equipment" id="equipment" class="form-control" placeholder="Enter equipment (optional)" value="{{ old('equipment') }}">
        </div>

        <button type="submit" class="btn btn-primary">Add Room</button>
    </form>
</div>
@endsection