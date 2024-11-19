@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Add New Presentation</h1>

        <!-- Form to submit new presentation -->
        <form action="{{ route('presentations.store') }}" method="POST">
            @csrf

            <!-- Conference Selection Dropdown -->
            <div class="form-group">
                <label for="conference_id">Select Conference</label>
                <select name="conference_id" class="form-control" required>
                    <option disabled selected>Select a conference</option>
                    @foreach($conferences as $conference)
                        <option value="{{ $conference->id }}">{{ $conference->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Presentation Title -->
            <div class="form-group">
                <label for="title">Presentation Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title" required>
            </div>

            <!-- Presentation Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
            </div>

            <!-- Presentation Start Time -->
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>

            <!-- Presentation End Time -->
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit Presentation</button>
        </form>
    </div>
@endsection