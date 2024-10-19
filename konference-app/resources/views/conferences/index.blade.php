@extends('layout.layout')

@section('title', 'Conferences')

@section('content')
    <h1>List of Conferences</h1>
    <ul class="list-group">
        @foreach($conferences as $conference)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $conference->name }}</span>
                <a href="{{ route('conferences.show', $conference->id) }}" class="btn btn-primary">Details</a>
            </li>
        @endforeach
    </ul>
@endsection