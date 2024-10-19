@extends('layout.layout')

@section('title', 'Conference Details')

@section('content')
    <h1>{{ $conference->name }}</h1>
    <p><strong>Description:</strong> {{ $conference->description }}</p>
    <p><strong>Location:</strong> {{ $conference->location }}</p>
    <p><strong>Capacity:</strong> {{ $conference->capacity }}</p>
    <p><strong>Price:</strong> ${{ $conference->price }}</p>

    <h2>Presentations</h2>
    <ul>
        @foreach($conference->presentations as $presentation)
            <li>
                <strong>{{ $presentation->title }}</strong><br>
                Speaker: {{ $presentation->user->name }}<br>
                Room: {{ $presentation->room->name }}<br>
                Start: {{ $presentation->start_time }}<br>
                End: {{ $presentation->end_time }}<br>
                <p>{{ $presentation->description }}</p>
            </li>
        @endforeach
    </ul>
@endsection
