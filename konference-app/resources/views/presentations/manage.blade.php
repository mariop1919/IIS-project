@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>Manage Presentations for {{ $conference->name }}</h1>

        <!-- List of presentations -->
        <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 15%;">Title</th>
                    <th style="width: 15%;">Speaker</th>
                    <th style="width: 18%;">Room</th>
                    <th style="width: 17.5%;">Start Time</th>
                    <th style="width: 17.5%;">End Time</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 12%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presentations as $presentation)
                    <tr>
                        <td>{{ $presentation->title }}</td>
                        <td>{{ $presentation->user->name }}</td>
                        <td>
                            <form action="{{ route('presentations.approve', $presentation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="presentation_id" value="{{ $presentation->id }}">

                                <!-- Room Selection (Only shown if no room assigned) -->
                                @if(!$presentation->room)
                                    <select name="room_id" class="form-control" style="width: 100%;" required>
                                        <option value="" disabled selected>Select a room</option>
                                        @foreach($conference->rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <!-- If the room is assigned, display the room name -->
                                    <div class="form-control" disabled>{{ $presentation->room->name }}</div>
                                @endif
                            </td>

                            <td>
                                <!-- Editable Start Time (if no room assigned) -->
                                @if(!$presentation->room)
                                    <input type="datetime-local" name="start_time" class="form-control" value="{{ $presentation->start_time }}" required style="width: 100%;">
                                @else
                                    <!-- If room is assigned, display the start time -->
                                    <div class="form-control" disabled>{{ $presentation->start_time }}</div>
                                @endif
                            </td>

                            <td>
                                <!-- Editable End Time (if no room assigned) -->
                                @if(!$presentation->room)
                                    <input type="datetime-local" name="end_time" class="form-control" value="{{ $presentation->end_time }}" required style="width: 100%;">
                                @else
                                    <!-- If room is assigned, display the end time -->
                                    <div class="form-control" disabled>{{ $presentation->end_time }}</div>
                                @endif
                            </td>

                            <td>
                                <span class="badge {{ $presentation->status == 'approved' ? 'bg-success' : ($presentation->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($presentation->status) }}
                                </span>
                            </td>

                            <td>
                                <!-- Approve button only visible for presentations that are pending -->
                                @if($presentation->status == 'pending' && !$presentation->room)
                                    <button type="submit" class="btn btn-success">Approve</button>
                                @else
                                    <!-- If approved or rejected, show the status -->
                                    <span class="badge {{ $presentation->status == 'approved' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($presentation->status) }}
                                    </span>
                                @endif
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary">Back to Conference</a>
    </div>
@endsection
