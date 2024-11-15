@extends('layouts.layout')

@section('title', 'Conferences')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List of Conferences</h2>
        
        @auth
            <a href="{{ route('conferences.create') }}" class="btn btn-success">Create New Conference</a>
        @endauth

        <a href="{{ route('reservations.create') }}" class="btn btn-primary">Create Reservation</a>
    </div>

    <ul class="list-group">
        @foreach($conferences as $conference)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $conference->name }}</span>
                
                <!-- Buttons container aligned to the right -->
                <div class="d-flex ms-auto">
                    <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary me-2">Details</a>
                    
                    @auth
                        @if(auth()->user()->id == $conference->user_id || auth()->user()->role == 'admin')
                            <a href="{{ route('conferences.edit', $conference->id) }}" class="btn btn-warning me-2">Edit</a>

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
@endsection
