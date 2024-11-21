@extends('layouts.layout')

@section('title', 'Conference Details')

@section('content')
    <div class="container mt-4">
        <h1>{{ $conference->name }}</h1>
        <p><strong>Description:</strong> {{ $conference->description }}</p>
        <p><strong>Location:</strong> {{ $conference->location }}</p>
        <p><strong>Capacity:</strong> {{ $conference->capacity }}</p>
        <p><strong>Price:</strong> ${{ $conference->price }}</p>

        @if($conference->start_time && $conference->end_time)
            <p><strong>Start Time:</strong> {{ $conference->start_time }}</p>
            <p><strong>End Time:</strong> {{ $conference->end_time }}</p>
        @else
            <p>Conference has not been approved yet.</p>
        @endif


        <h2>Presentations</h2>
        @if($approvedPresentations->isEmpty())
            <p>No presentations available for this conference.</p>
        @else
            <ul class="list-group">
                @foreach($approvedPresentations as $presentation)
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
