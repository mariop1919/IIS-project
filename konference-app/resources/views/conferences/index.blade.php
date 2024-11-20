@extends('layouts.layout')

@section('title', 'Conferences')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 ">
        <h2>List of Conferences</h2>
        
        <div>
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.index') }}" class="btn btn-danger ms-2">Admin Panel</a>
                @endif
                <a href="{{ route('conferences.create') }}" class="btn btn-success">Create Conference</a>
                <a href="{{ route('presentations.create') }}" class="btn btn-success ms-2">Create Presentation</a>
                <a href="{{ route('conference_rooms.create') }}" class="btn btn-primary">Create Room</a>
            @endauth
            <a href="{{ route('reservations.create') }}" class="btn btn-primary ms-2">Create Reservation</a>
        </div>
    </div>

    <ul class="list-group">
        @foreach($conferences as $conference)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    {{ $conference->name }}
                    @if($conference->is_full)
                        <span class="text-danger ms-2" style="font-size: 1.5rem;">Sold Out</span>
                    @endif
                </span>

                <div class="d-flex align-items-center">
                    <span class="me-3">Capacity: {{ $conference->reservations->count() }}/{{ $conference->capacity }}</span>
                    <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary me-2">Details</a>
                    
                    @auth
                        @if(auth()->user()->id == $conference->user_id || auth()->user()->role == 'admin')
                            <a href="{{ route('conferences.edit', $conference->id) }}" class="btn btn-warning me-2">Edit</a>
                            <a href="{{ route('reservations.manage', $conference->id) }}" class="btn btn-dark me-2">Manage Reservations</a>
                            <a href="{{ route('presentations.manage', $conference->id) }}" class="btn btn-info me-2">Manage Presentations</a>
                            <form action="{{ route('conferences.destroy', $conference->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this conference?')">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </li>
        @endforeach
    </ul>


<style>
.btn {
    margin-right: 0.25rem; /* Ensures spacing between buttons */
}
.btn:last-child {
    margin-right: 0; /* Removes extra spacing on the last button */
}
</style>
@endsection
