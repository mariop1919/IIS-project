@extends('layouts.layout')

@section('title', 'Attendee Presentations Schedule')

@section('content')
<div class="container">
    <h1>Attendee Presentations Schedule</h1>

    <!-- Display current week range -->
    <div class="week-navigation my-3 text-center">
        <a href="{{ route('presentations.attendeeSchedule', ['date' => $startOfWeek->copy()->subWeek()->toDateString()]) }}" class="btn btn-secondary">&lt; Previous Week</a>
        <span class="mx-3 font-weight-bold">{{ $formattedStartOfWeek }} - {{ $formattedEndOfWeek }}</span>
        <a href="{{ route('presentations.attendeeSchedule', ['date' => $startOfWeek->copy()->addWeek()->toDateString()]) }}" class="btn btn-secondary">Next Week &gt;</a>
    </div>

    <!-- Check if the user has any presentations -->
    @if($presentations->isEmpty())
        <div class="alert alert-info">
            You don't have any presentations for this week.
        </div>
    @else
        <!-- Schedule grouped by day -->
        <div class="schedule">
            @foreach($presentations as $day => $dayPresentations)
                <h3>{{ $day }}</h3>
                <div class="row">
                    @foreach($dayPresentations as $presentation)
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
                                    
                                    <!-- Add to My Schedule Button -->
                                    <form action="{{ route('presentations.personalSchedule.add', $presentation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" {{ $user->attendingPresentations->contains($presentation->id) ? 'disabled' : '' }}>Add to My Schedule</button>
                                    </form>

                                    <!-- Vote Button -->
                                    @if ($user->votedPresentations->contains($presentation->id))
                                    <!-- Unvote Form -->
                                    <form action="{{ route('presentations.unvote', $presentation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE') <!-- Makes it a DELETE request -->
                                        <button type="submit" class="btn btn-danger">Unvote</button>
                                    </form>
                                    @else
                                    <!-- Vote Form -->
                                    <form action="{{ route('presentations.vote', $presentation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Vote</button>
                                    </form>
                                    @endif

                                    <!-- Button to trigger Add Question modal -->
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addQuestionModal-{{ $presentation->id }}">
                                        Add Question
                                    </button>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Modal for adding question -->
                        <div class="modal fade" id="addQuestionModal-{{ $presentation->id }}" tabindex="-1" role="dialog" aria-labelledby="addQuestionModalLabel-{{ $presentation->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addQuestionModalLabel-{{ $presentation->id }}">Add Question to {{ $presentation->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('presentations.addQuestion', $presentation->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="question">Question</label>
                                                <input type="text" name="question" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Question</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>
@endsection
