@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Manage Presentations for {{ $conference->name }}</h1>

    <!-- List of presentations -->
    <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 12%;">Title</th>
                <th style="width: 15%;">Speaker</th>
                <th style="width: 18%;">Room</th>
                <th style="width: 19%;">Start Time</th>
                <th style="width: 19%;">End Time</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presentations as $presentation)
            <tr data-presentation-id="{{ $presentation->id }}">
                <td>{{ $presentation->title }}</td>
                <td>{{ $presentation->user->name }}</td>
                <td>
                    @if($presentation->status == 'approved')
                        <!-- Show assigned room if approved -->
                        <div class="form-control" disabled>{{ $presentation->room->name ?? 'N/A' }}</div>
                    @else
                        <!-- Room selection for pending presentations -->
                        <form action="{{ route('presentations.approve', $presentation->id) }}" method="POST" class="approve-form" data-presentation-id="{{ $presentation->id }}">
                            @csrf
                            <select name="room_id" class="form-control" required>
                                <option value="" disabled selected>Select a room</option>
                                @foreach($conference->rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                    @endif
                </td>
                <td>
                    @if($presentation->status == 'approved')
                        <!-- Non-editable start time -->
                        <div class="form-control" disabled>{{ $presentation->start_time }}</div>
                    @else
                        <!-- Editable start time -->
                        <input type="datetime-local" name="start_time" class="form-control" value="{{ $presentation->start_time }}" required>
                    @endif
                </td>
                <td>
                    @if($presentation->status == 'approved')
                        <!-- Non-editable end time -->
                        <div class="form-control" disabled>{{ $presentation->end_time }}</div>
                    @else
                        <!-- Editable end time -->
                        <input type="datetime-local" name="end_time" class="form-control" value="{{ $presentation->end_time }}" required>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $presentation->status == 'approved' ? 'bg-success' : ($presentation->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                        {{ ucfirst($presentation->status) }}
                    </span>
                </td>
                <td>
                    @if($presentation->status == 'pending')
                        <!-- Approve button -->
                        <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    @else
                        <!-- Display edit button if already approved -->
                        <a href="{{ route('presentations.edit', $presentation->id) }}" class="btn btn-warning">Edit</a>
                        <!-- Display status if already approved -->
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary">Back to Conference</a>
</div>

<!-- JavaScript for AJAX -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all approve forms
        const approveForms = document.querySelectorAll('.approve-form');

        approveForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(this); // Collect form data
                const presentationId = this.dataset.presentationId; // Get the presentation ID

                axios.post(this.action, formData)
                    .then(response => {
                        // Update the row dynamically
                        const row = document.querySelector(`[data-presentation-id="${presentationId}"]`);
                        const data = response.data;

                        // Update the row with new approved content
                        row.innerHTML = `
                            <td>${data.title}</td>
                            <td>${data.speaker}</td>
                            <td><div class="form-control" disabled>${data.room}</div></td>
                            <td><div class="form-control" disabled>${data.start_time}</div></td>
                            <td><div class="form-control" disabled>${data.end_time}</div></td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>
                                <a href="/presentations/${data.id}/edit" class="btn btn-warning">Edit</a>
                            </td>
                        `;
                    })
                    .catch(error => {
                        console.error(error);
                        alert('There was an error processing your request.');
                    });
            });
        });
    });
</script>
@endsection
