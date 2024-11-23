@extends('layouts.layout')

@section('title', 'Best Presentations')

@section('content')
<div class="container">
    <h1>Best Presentations Leaderboard</h1>

    <!-- Conference selection form -->
    <form action="{{ route('presentations.leaderboard') }}" method="GET" class="form-inline my-3">
        <label for="conference_id" class="mr-2">Select Conference:</label>
        <select name="conference_id" id="conference_id" class="form-control mr-3">
            <option value="">-- Choose Conference --</option>
            @foreach ($conferences as $conference)
                <option value="{{ $conference->id }}" {{ $selectedConferenceId == $conference->id ? 'selected' : '' }}>
                    {{ $conference->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Show Leaderboard</button>
    </form>

    <!-- Leaderboard table -->
    @if (!empty($presentations))
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Title</th>
                    <th>Speaker</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presentations as $index => $presentation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $presentation->title }}</td>
                        <td>{{ $presentation->user->name }}</td> <!-- Assuming a `user` relationship for speaker -->
                        <td>{{ $presentation->voted_users_count }}</td> <!-- Vote count from withCount -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-4">Please select a conference to view the leaderboard.</p>
    @endif
</div>
@endsection
