@extends('layout.layout')

@section('title', 'Conferences')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List of Conferences</h2>
        
        @auth
            <a href="{{ route('conferences.create') }}" class="btn btn-success">Create New Conference</a>
        @endauth
    </div>

    <ul class="list-group">
        @foreach($conferences as $conference)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $conference->name }}</span>
                <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary">Details</a>
            </li>
        @endforeach
    </ul>
@endsection
