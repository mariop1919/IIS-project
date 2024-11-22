@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <h1>Manage Presentations for {{ $conference->name }}</h1>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <!-- List of presentations -->
    <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
        <thead>
            <tr>
                <th style="width: 12%;">Title</th>
                <th style="width: 15%;">Speaker</th>
                <th style="width: 18%;">Room <span class="text-danger">*</span></th>
                <th style="width: 19%;">Start Time <span class="text-danger">*</span></th>
                <th style="width: 19%;">End Time <span class="text-danger">*</span></th>
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
                    @if($presentation->status == 'approved')
                        <div class="form-control" disabled>{{ $presentation->room->name ?? 'N/A' }}</div>
                    @else
                        <form action="{{ route('presentations.approve', $presentation->id) }}" method="POST">
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
                        <div class="form-control" disabled>{{ $presentation->start_time }}</div>
                    @else
                        <input type="datetime-local" name="start_time" class="form-control" value="{{ $presentation->start_time }}" required>
                    @endif
                </td>
                <td>
                    @if($presentation->status == 'approved')
                        <div class="form-control" disabled>{{ $presentation->end_time }}</div>
                    @else
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
                        <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('presentations.destroy', $presentation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this presentation? It will be deleted from the database.')">Reject</button>
                        </form>
                    @else
                        <a href="{{ route('presentations.edit', $presentation->id) }}" class="btn btn-warning">Edit</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary">Back to Conference</a>
</div>
@endsection
