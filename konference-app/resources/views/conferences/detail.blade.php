@extends('layouts.layout')

@section('title', 'Conference Details')

@section('content')
    <div class="container mt-4">
        <h1>{{ $conference->name }}</h1>
        <p><strong>Description:</strong> {{ $conference->description }}</p>
        <p><strong>Location:</strong> {{ $conference->location }}</p>
        <p><strong>Capacity:</strong> {{ $conference->capacity }}</p>
        <p><strong>Price:</strong> ${{ $conference->price }}</p>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('conference_rooms.create', $conference) }}" class="btn btn-primary mb-3">
            Add Room
        </a>
        @endif
        <!-- Button for Admin to Add Room -->

        <h2>Presentations</h2>
        @if($conference->presentations->isEmpty())
            <p>No presentations available for this conference.</p>
        @else
            <ul class="list-group">
                @foreach($conference->presentations as $presentation)
                    <li class="list-group-item">
                        <strong>{{ $presentation->title }}</strong><br>
                        Speaker: {{ $presentation->user->name }}<br>
                        Start: {{ $presentation->start_time }}<br>
                        End: {{ $presentation->end_time }}<br>
                        <p>{{ $presentation->description }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
