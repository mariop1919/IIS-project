@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Add New Presentation to {{ $conference->name }}</h1>

        <!-- Form to submit new presentation -->
        <form action="{{ route('presentations.register', $conference->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Presentation Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit Presentation</button>
        </form>
    </div>
@endsection
