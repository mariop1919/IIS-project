@extends('layouts.layout')

@section('title', 'Conference Details')

@section('content')
    <div class="container mt-4">
        <h1>{{ $conference->name }}</h1>
        <p><strong>Description:</strong> {{ $conference->description }}</p>
        <p><strong>Location:</strong> {{ $conference->location }}</p>
        <p><strong>Capacity:</strong> {{ $conference->capacity }}</p>
        <p><strong>Price:</strong> {{ $conference->price }} $</p>

        @if($conference->start_time && $conference->end_time)
            <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($conference->start_time)->format('l, F j, Y - g:i A') }}</p>
            <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($conference->end_time)->format('l, F j, Y - g:i A') }}</p>
        @else
            <p class="text-danger">Conference start and end times have not been approved yet.</p>
        @endif

        <h2>Presentations</h2>
        @if($approvedPresentations->isEmpty())
            <p>No presentations available for this conference.</p>
        @else
            <div class="row">
                @foreach($approvedPresentations as $presentation)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <img src="{{ $presentation->photo }}" class="card-img-top" alt="{{ $presentation->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $presentation->title }}</h5>
                                <p class="card-text"><strong>Speaker:</strong> {{ $presentation->user->name }}</p>
                                <p class="card-text"><strong>Room:</strong> {{ $presentation->room->name }}</p>
                                <p class="card-text">
                                    <strong>Time:</strong> 
                                    {{ \Carbon\Carbon::parse($presentation->start_time)->format('l, F j, Y - g:i A') }} 
                                    <span class="text-muted">to</span> 
                                    {{ \Carbon\Carbon::parse($presentation->end_time)->format('g:i A') }}
                                </p>
                                <p class="card-text">{{ $presentation->description }}</p>
                                <h5>Questions:</h5>
                                @if($presentation->questions->isEmpty())
                                    <p>No questions for this presentation.</p>
                                @else
                                    <ul>
                                        @foreach($presentation->questions as $question)
                                            <li>{{ $question->question }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add the CSS inside the <style> tag -->
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
        }

        .card:hover {
            transform: scale(1.05); /* Slightly enlarges the card */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Adds a stronger shadow effect */
        }
        .card-img-top {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            margin-bottom: 10px;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            margin-bottom: 10px;
        }
    </style>
@endsection
