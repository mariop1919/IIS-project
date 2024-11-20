@extends('layouts.layout')

@section('title', 'My Presentations Timetable')

@section('content')
<div class="container">
    <h1>My Presentations Schedule</h1>

    <!-- Display current week range -->
    <div class="week-navigation my-3 text-center">
        <a href="{{ route('presentations.timetable', ['date' => $startOfWeek->copy()->subWeek()->toDateString()]) }}" class="btn btn-secondary">&lt; Previous Week</a>
        <span class="mx-3 font-weight-bold">{{ $formattedStartOfWeek }} - {{ $formattedEndOfWeek }}</span>
        <a href="{{ route('presentations.timetable', ['date' => $startOfWeek->copy()->addWeek()->toDateString()]) }}" class="btn btn-secondary">Next Week &gt;</a>
    </div>

    <!-- Check if the user has any presentations -->
    @if($presentations->isEmpty())
        <div class="alert alert-info">
            You don't have any presentations for this week.
        </div>
    @else
        <!-- Timetable grouped by day -->
        <div class="timetable">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <h3>{{ $day }}</h3>
                <div class="row">
                    @if(isset($presentations[$day]) && $presentations[$day]->isNotEmpty())
                        @foreach($presentations[$day] as $presentation)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $presentation->title }}</h5>
                                        <p>Room: {{ $presentation->room->name ?? 'N/A' }}</p>
                                        <p>
                                            {{ \Carbon\Carbon::parse($presentation->start_time)->format('g:i A') }} - 
                                            {{ \Carbon\Carbon::parse($presentation->end_time)->format('g:i A') }}
                                        </p>
                                        <p>Speaker: {{ $presentation->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No presentations scheduled for {{ $day }}.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>
@endsection
